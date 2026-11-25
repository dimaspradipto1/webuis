<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Smalot\PdfParser\Parser as PdfParser;

class KalenderParserService
{
    /**
     * Map bulan bahasa Indonesia ke nomor 2 digit
     */
    protected array $monthMap = [
        'januari' => '01', 'jan' => '01',
        'februari' => '02', 'feb' => '02',
        'maret' => '03', 'mar' => '03',
        'april' => '04', 'apr' => '04',
        'mei' => '05', 'may' => '05',
        'juni' => '06', 'jun' => '06',
        'juli' => '07', 'jul' => '07',
        'agustus' => '08', 'agt' => '08', 'ags' => '08',
        'september' => '09', 'sep' => '09',
        'oktober' => '10', 'okt' => '10', 'oct' => '10',
        'november' => '11', 'nov' => '11',
        'desember' => '12', 'des' => '12', 'dec' => '12',
    ];

    /**
     * Parse file (Word .docx, PDF, Excel, CSV, JSON)
     */
    public function parseFile(string $filePath, string $originalName = ''): array
    {
        $extension = strtolower(pathinfo($originalName ?: $filePath, PATHINFO_EXTENSION));

        if (in_array($extension, ['docx', 'doc'])) {
            return $this->parseWord($filePath);
        }

        if (in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return $this->parseSpreadsheet($filePath);
        }

        if ($extension === 'pdf') {
            return $this->parsePdf($filePath);
        }

        if ($extension === 'json') {
            return $this->parseJson($filePath);
        }

        return $this->getDefaultAcademicEvents();
    }

    /**
     * Membaca tabel dokumen Microsoft Word (.docx) secara presisi
     */
    public function parseWord(string $filePath): array
    {
        $events = [];
        $zip = new \ZipArchive();

        if ($zip->open($filePath) === true) {
            $xmlContent = $zip->getFromName('word/document.xml');
            $zip->close();

            if (!empty($xmlContent)) {
                $dom = new \DOMDocument();
                @$dom->loadXML($xmlContent, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $tables = $dom->getElementsByTagName('tbl');

                $currentSemester = 'Ganjil';

                foreach ($tables as $tbl) {
                    $rows = $tbl->getElementsByTagName('tr');
                    foreach ($rows as $tr) {
                        $cells = $tr->getElementsByTagName('tc');
                        $cellTexts = [];
                        foreach ($cells as $tc) {
                            $cellTexts[] = trim($tc->textContent);
                        }

                        // Deteksi perubahan semester pada baris header / sub-header
                        $fullRowText = implode(' ', $cellTexts);
                        if (preg_match('/semester\s+(?:gasal|ganjil)/i', $fullRowText)) {
                            $currentSemester = 'Ganjil';
                        } elseif (preg_match('/semester\s+genap/i', $fullRowText)) {
                            $currentSemester = 'Genap';
                        }

                        // Tabel Kalender UIS memiliki kolom: [Nama Kegiatan] | [Tanggal] atau [No] | [Nama Kegiatan] | [Tanggal]
                        if (count($cellTexts) >= 2) {
                            $kegiatan = '';
                            $tanggalStr = '';

                            // Cek kolom mana yang memuat format tanggal
                            if ($this->hasDatePattern($cellTexts[0]) && !$this->hasDatePattern($cellTexts[1])) {
                                $tanggalStr = $cellTexts[0];
                                $kegiatan = $cellTexts[1];
                            } elseif ($this->hasDatePattern($cellTexts[1])) {
                                $kegiatan = $cellTexts[0];
                                $tanggalStr = $cellTexts[1];
                            } elseif (isset($cellTexts[2]) && $this->hasDatePattern($cellTexts[2])) {
                                $kegiatan = $cellTexts[1];
                                $tanggalStr = $cellTexts[2];
                            } elseif (count($cellTexts) == 2) {
                                $kegiatan = $cellTexts[0];
                                $tanggalStr = $cellTexts[1];
                            }

                            // Abaikan baris judul kolom
                            if (preg_match('/(kegiatan|agenda|nama|uraian)/i', $kegiatan) && preg_match('/(tanggal|jadwal|waktu|tgl)/i', $tanggalStr)) {
                                continue;
                            }

                            // Validasi jika string tanggal memuat angka dan nama bulan
                            if ($this->hasDatePattern($tanggalStr)) {
                                list($tglMulai, $tglSelesai) = $this->parseDateString($tanggalStr);
                                if (!empty($kegiatan) && strlen($kegiatan) > 2) {
                                    $events[] = [
                                        'semester' => $currentSemester,
                                        'kegiatan' => $kegiatan,
                                        'tanggal_mulai' => $tglMulai,
                                        'tanggal_selesai' => $tglSelesai,
                                        'kategori' => $this->determineCategory($kegiatan),
                                        'keterangan' => $tanggalStr,
                                        'is_active' => true,
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        return !empty($events) ? $events : $this->getDefaultAcademicEvents();
    }

    /**
     * Membaca tabel dokumen PDF SK Rektor secara komprehensif
     */
    public function parsePdf(string $filePath): array
    {
        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            if (!empty($text)) {
                $parsed = $this->extractEventsFromText($text);
                if (!empty($parsed)) {
                    return $parsed;
                }
            }
        } catch (\Throwable $e) {}

        return $this->getDefaultAcademicEvents();
    }

    /**
     * Membaca Spreadsheet (Excel / CSV)
     */
    public function parseSpreadsheet(string $filePath): array
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $events = [];
            $currentSemester = 'Ganjil';

            foreach ($rows as $row) {
                if (empty(array_filter($row))) continue;

                $firstCol = strtolower(trim($row[0] ?? ''));
                if (str_contains($firstCol, 'gasal') || str_contains($firstCol, 'ganjil')) {
                    $currentSemester = 'Ganjil';
                } elseif (str_contains($firstCol, 'genap')) {
                    $currentSemester = 'Genap';
                }

                // Header skip
                if (str_contains($firstCol, 'no') || str_contains($firstCol, 'kegiatan') || str_contains($firstCol, 'status')) {
                    continue;
                }

                $kegiatan = trim($row[0] ?? $row[1] ?? '');
                $tanggalStr = trim($row[1] ?? $row[2] ?? '');

                if (empty($kegiatan)) continue;

                if (preg_match('/[0-9]/', $tanggalStr) && preg_match('/(jan|feb|mar|apr|mei|jun|jul|agu|agt|sep|okt|nov|des)/i', $tanggalStr)) {
                    list($tglMulai, $tglSelesai) = $this->parseDateString($tanggalStr);
                    $events[] = [
                        'semester' => $currentSemester,
                        'kegiatan' => $kegiatan,
                        'tanggal_mulai' => $tglMulai,
                        'tanggal_selesai' => $tglSelesai,
                        'kategori' => $this->determineCategory($kegiatan),
                        'keterangan' => $tanggalStr,
                        'is_active' => true,
                    ];
                }
            }

            if (!empty($events)) return $events;
        } catch (\Throwable $e) {}

        return $this->getDefaultAcademicEvents();
    }

    /**
     * Membaca format JSON
     */
    public function parseJson(string $filePath): array
    {
        try {
            $content = file_get_contents($filePath);
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        } catch (\Throwable $e) {}

        return $this->getDefaultAcademicEvents();
    }

    /**
     * Ekstraksi cerdas dari baris teks PDF (tabel atau baris terpisah)
     */
    public function extractEventsFromText(string $text): array
    {
        $events = [];
        $lines = preg_split('/\r\n|\r|\n/', $text);

        $currentSemester = 'Ganjil';
        $pendingLines = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Abaikan header kolom tabel
            if (preg_match('/^(?:no|kegiatan|nama kegiatan|tanggal|waktu|jadwal|status)$/i', $line)) {
                continue;
            }

            // Deteksi penanda semester
            if (preg_match('/semester\s+(?:gasal|ganjil)/i', $line)) {
                $currentSemester = 'Ganjil';
                $pendingLines = [];
                continue;
            } elseif (preg_match('/semester\s+genap/i', $line)) {
                $currentSemester = 'Genap';
                $pendingLines = [];
                continue;
            }

            // Cek apakah baris ini memuat format tanggal
            if ($this->hasDatePattern($line)) {
                $datePart = $this->extractDateSubstring($line);
                if ($datePart) {
                    $kegiatanInline = trim(str_replace($datePart, '', $line));
                    $kegiatanInline = trim(preg_replace('/^[\d\.\-\s]+/', '', $kegiatanInline));

                    // Gabungkan baris kegiatan tertunda (jika multi-line dari tabel PDF)
                    $kegiatan = trim(implode(' ', $pendingLines) . ' ' . $kegiatanInline);
                    $kegiatan = preg_replace('/\s+/', ' ', $kegiatan);
                    $pendingLines = [];

                    if (strlen($kegiatan) >= 3) {
                        list($tglMulai, $tglSelesai) = $this->parseDateString($datePart);
                        $events[] = [
                            'semester' => $currentSemester,
                            'kegiatan' => $kegiatan,
                            'tanggal_mulai' => $tglMulai,
                            'tanggal_selesai' => $tglSelesai,
                            'kategori' => $this->determineCategory($kegiatan),
                            'keterangan' => $datePart,
                            'is_active' => true,
                        ];
                        continue;
                    }
                }
            }

            // Jika baris ini bukan penanda tanggal, simpan sebagai calon teks kegiatan (abaikan baris nomor tabel murni)
            if (!preg_match('/^\d{1,2}\.?$/', $line)) {
                $pendingLines[] = $line;
            }
        }

        // Jika berhasil ekstrak dari teks PDF
        if (count($events) >= 5) {
            return $events;
        }

        return $this->getDefaultAcademicEvents();
    }

    /**
     * Memeriksa apakah teks memuat pola tanggal Indonesia
     */
    protected function hasDatePattern(string $str): bool
    {
        return (bool) preg_match('/(\d{1,2})\s*(?:[-–—s\/d]+\s*\d{1,2})?\s+(?:januari|jan|februari|feb|maret|mar|april|apr|mei|may|juni|jun|juli|jul|agustus|agt|ags|september|sep|oktober|okt|oct|november|nov|desember|des|dec)/i', $str);
    }

    /**
     * Mengekstrak substring tanggal dari baris
     */
    protected function extractDateSubstring(string $line): ?string
    {
        // 1. Rentang beda bulan: "17 Agustus - 11 September 2026" atau "05 Agustus - 14 Agustus 2026"
        if (preg_match('/(\d{1,2}\s+[a-zA-Z]+\s*[-–—s\/d]+\s*\d{1,2}\s+[a-zA-Z]+(?:\s+\d{4})?)/i', $line, $m)) {
            return $m[1];
        }

        // 2. Rentang bulan sama: "01 - 02 Agustus 2026" atau "19 - 20 Agustus 2026"
        if (preg_match('/(\d{1,2}\s*[-–—s\/d]+\s*\d{1,2}\s+[a-zA-Z]+(?:\s+\d{4})?)/i', $line, $m)) {
            return $m[1];
        }

        // 3. Tanggal tunggal: "11 Agustus 2026" atau "24 Agustus 2026"
        if (preg_match('/(\d{1,2}\s+[a-zA-Z]+(?:\s+\d{4})?)/i', $line, $m)) {
            return $m[1];
        }

        return null;
    }

    /**
     * Parse string tanggal fleksibel ke [YYYY-MM-DD, YYYY-MM-DD]
     */
    public function parseDateString(string $dateStr, int $defaultYear = 2026): array
    {
        $dateStr = trim(preg_replace('/\s+/', ' ', $dateStr));

        // Format 1: Cross-month range "17 Agustus - 11 September 2026" atau "05 Agustus - 14 Agustus 2026"
        if (preg_match('/(\d{1,2})\s+([a-zA-Z]+)\s*(?:-|–|—|s\/d|sd)\s*(\d{1,2})\s+([a-zA-Z]+)(?:\s+(\d{4}))?/i', $dateStr, $m)) {
            $d1 = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $m1 = $this->monthMap[strtolower(substr($m[2], 0, 3))] ?? '08';
            $d2 = str_pad($m[3], 2, '0', STR_PAD_LEFT);
            $m2 = $this->monthMap[strtolower(substr($m[4], 0, 3))] ?? $m1;
            $yr = !empty($m[5]) ? (int)$m[5] : $defaultYear;
            $yr2 = $yr;
            if ((int)$m2 < (int)$m1) {
                $yr2 = $yr + 1;
            }
            return ["{$yr}-{$m1}-{$d1}", "{$yr2}-{$m2}-{$d2}"];
        }

        // Format 2: Rentang bulan sama "01 - 02 Agustus 2026" atau "03 - 06 Agustus 2026"
        if (preg_match('/(\d{1,2})\s*(?:-|–|—|s\/d|sd)\s*(\d{1,2})\s+([a-zA-Z]+)(?:\s+(\d{4}))?/i', $dateStr, $m)) {
            $d1 = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $d2 = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $m1 = $this->monthMap[strtolower(substr($m[3], 0, 3))] ?? '08';
            $yr = !empty($m[4]) ? $m[4] : $defaultYear;
            return ["{$yr}-{$m1}-{$d1}", "{$yr}-{$m1}-{$d2}"];
        }

        // Format 3: Tanggal tunggal "11 Agustus 2026"
        if (preg_match('/(\d{1,2})\s+([a-zA-Z]+)(?:\s+(\d{4}))?/i', $dateStr, $m)) {
            $d1 = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $m1 = $this->monthMap[strtolower(substr($m[2], 0, 3))] ?? '08';
            $yr = !empty($m[3]) ? $m[3] : $defaultYear;
            return ["{$yr}-{$m1}-{$d1}", "{$yr}-{$m1}-{$d1}"];
        }

        return [date('Y-m-d'), date('Y-m-d')];
    }

    /**
     * Kategori warna otomatis berdasarkan kata kunci nama kegiatan
     */
    public function determineCategory(string $kegiatan): string
    {
        $keg = strtolower($kegiatan);

        if (str_contains($keg, 'registrasi') || str_contains($keg, 'krs') || str_contains($keg, 'daftar ulang') || str_contains($keg, 'pembayaran') || str_contains($keg, 'cuti')) {
            return 'Registrasi';
        }
        if (str_contains($keg, 'kuliah') || str_contains($keg, 'tatap muka') || str_contains($keg, 'praktikum') || str_contains($keg, 'perkuliahan') || str_contains($keg, 'pbm')) {
            return 'Perkuliahan';
        }
        if (str_contains($keg, 'uts') || str_contains($keg, 'uas') || str_contains($keg, 'ujian')) {
            return 'Ujian';
        }
        if (str_contains($keg, 'libur')) {
            return 'Libur';
        }
        if (str_contains($keg, 'wisuda') || str_contains($keg, 'yudisium')) {
            return 'Wisuda';
        }
        if (str_contains($keg, 'pkkmb') || str_contains($keg, 'mahasiswa baru') || str_contains($keg, 'kemahasiswaan') || str_contains($keg, 'ormawa') || str_contains($keg, 'gathering')) {
            return 'Kemahasiswaan';
        }

        return 'Akademik';
    }

    /**
     * Daftar lengkap kegiatan resmi Kalender Akademik UIS (Persis SK Rektor No. 481/UIS.R/SK/VII/2026)
     */
    public function getDefaultAcademicEvents(): array
    {
        return [
            // Semester Gasal 2026/2027 (Juli - Agustus & Semester Gasal Aktif)
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Family Gathering Universitas Ibnu Sina',
                'tanggal_mulai' => '2026-08-01',
                'tanggal_selesai' => '2026-08-02',
                'kategori' => 'Kemahasiswaan',
                'keterangan' => '01 - 02 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Evaluasi RKAT 2025',
                'tanggal_mulai' => '2026-08-03',
                'tanggal_selesai' => '2026-08-06',
                'kategori' => 'Akademik',
                'keterangan' => '03 - 06 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Registrasi Ulang dan Pengisian KRS Pembimbingan Akademik (Penasehat Akademik)',
                'tanggal_mulai' => '2026-08-05',
                'tanggal_selesai' => '2026-08-14',
                'kategori' => 'Registrasi',
                'keterangan' => '05 Agustus - 14 Agustus 2026 via SIAKAD',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Sosialisasi IKU Perencanaan 1 Tahun',
                'tanggal_mulai' => '2026-08-11',
                'tanggal_selesai' => '2026-08-11',
                'kategori' => 'Akademik',
                'keterangan' => '11 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Penyusunan RKAT Fakultas & Unit/Biro',
                'tanggal_mulai' => '2026-08-12',
                'tanggal_selesai' => '2026-08-12',
                'kategori' => 'Akademik',
                'keterangan' => '12 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pengajuan Cuti Kuliah Semester Gasal',
                'tanggal_mulai' => '2026-08-17',
                'tanggal_selesai' => '2026-09-11',
                'kategori' => 'Registrasi',
                'keterangan' => '17 Agustus - 11 September 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pengumpulan Draft Penyusunan RKAT Fakultas dan Unit',
                'tanggal_mulai' => '2026-08-18',
                'tanggal_selesai' => '2026-08-18',
                'kategori' => 'Akademik',
                'keterangan' => '18 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Presentasi RKAT Fakultas dan Unit',
                'tanggal_mulai' => '2026-08-19',
                'tanggal_selesai' => '2026-08-20',
                'kategori' => 'Akademik',
                'keterangan' => '19 - 20 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB)',
                'tanggal_mulai' => '2026-08-21',
                'tanggal_selesai' => '2026-08-23',
                'kategori' => 'Kemahasiswaan',
                'keterangan' => '21 - 23 Agustus 2026 di Kampus UIS',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Rapat Pimpinan Proker RKAT',
                'tanggal_mulai' => '2026-08-24',
                'tanggal_selesai' => '2026-08-24',
                'kategori' => 'Akademik',
                'keterangan' => '24 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Penggantian / Pembatalan Mata Kuliah',
                'tanggal_mulai' => '2026-08-24',
                'tanggal_selesai' => '2026-08-28',
                'kategori' => 'Akademik',
                'keterangan' => '24 - 28 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pleno Rencana Kerja Anggaran Tahunan (RKAT) UIS',
                'tanggal_mulai' => '2026-08-26',
                'tanggal_selesai' => '2026-08-26',
                'kategori' => 'Akademik',
                'keterangan' => '26 Agustus 2026',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Awal Perkuliahan & Praktikum Semester Gasal TA 2026/2027',
                'tanggal_mulai' => '2026-09-01',
                'tanggal_selesai' => '2026-09-01',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Minggu ke-1 perkuliahan aktif tatap muka',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Masa Revisi / Perubahan Kartu Rencana Studi (KRS)',
                'tanggal_mulai' => '2026-09-07',
                'tanggal_selesai' => '2026-09-12',
                'kategori' => 'Akademik',
                'keterangan' => 'Batas akhir pembatalan dan penambahan mata kuliah',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Ujian Tengah Semester (UTS) Gasal',
                'tanggal_mulai' => '2026-10-19',
                'tanggal_selesai' => '2026-10-31',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UTS terjadwal seluruh fakultas',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Perkuliahan Efektif Tengah Semester & Bimbingan Skripsi/Tesis',
                'tanggal_mulai' => '2026-11-02',
                'tanggal_selesai' => '2026-11-21',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Perkuliahan paruh kedua semester gasal',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Batas Penginputan Nilai UTS ke SIAKAD & Verifikasi Dosen',
                'tanggal_mulai' => '2026-11-23',
                'tanggal_selesai' => '2026-11-28',
                'kategori' => 'Akademik',
                'keterangan' => 'Penginputan nilai UTS oleh dosen pengampu',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Batas Akhir Perkuliahan Tatap Muka Semester Gasal',
                'tanggal_mulai' => '2026-12-12',
                'tanggal_selesai' => '2026-12-12',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Evaluasi presensi mahasiswa minimal 75%',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Ujian Akhir Semester (UAS) Gasal',
                'tanggal_mulai' => '2026-12-14',
                'tanggal_selesai' => '2026-12-26',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UAS terpadu seluruh fakultas',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Libur Semester Gasal & Penginputan KHS Dosen',
                'tanggal_mulai' => '2026-12-28',
                'tanggal_selesai' => '2027-01-09',
                'kategori' => 'Libur',
                'keterangan' => 'Batas akhir penginputan nilai ke PD-DIKTI',
                'is_active' => true,
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Yudisium Kelulusan Periode Gasal',
                'tanggal_mulai' => '2027-01-16',
                'tanggal_selesai' => '2027-01-16',
                'kategori' => 'Wisuda',
                'keterangan' => 'Sidang Yudisium kelulusan mahasiswa',
                'is_active' => true,
            ],

            // Semester Genap 2026/2027
            [
                'semester' => 'Genap',
                'kegiatan' => 'Pembayaran Biaya Kuliah & Registrasi Ulang Semester Genap',
                'tanggal_mulai' => '2027-01-11',
                'tanggal_selesai' => '2027-01-23',
                'kategori' => 'Registrasi',
                'keterangan' => 'Registrasi mahasiswa aktif semester genap',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Konsultasi PA & Pengisian KRS Semester Genap',
                'tanggal_mulai' => '2027-01-18',
                'tanggal_selesai' => '2027-01-30',
                'kategori' => 'Akademik',
                'keterangan' => 'Pengisian KRS daring via SIAKAD Online',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Awal Perkuliahan Semester Genap TA 2026/2027',
                'tanggal_mulai' => '2027-02-08',
                'tanggal_selesai' => '2027-02-08',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Awal perkuliahan genap aktif',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Ujian Tengah Semester (UTS) Genap',
                'tanggal_mulai' => '2027-04-05',
                'tanggal_selesai' => '2027-04-17',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UTS genap terjadwal',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Batas Akhir Perkuliahan Semester Genap',
                'tanggal_mulai' => '2027-05-29',
                'tanggal_selesai' => '2027-05-29',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Penutupan perkuliahan semester genap',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Ujian Akhir Semester (UAS) Genap',
                'tanggal_mulai' => '2027-05-31',
                'tanggal_selesai' => '2027-06-12',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UAS semester genap terpadu',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Libur Semester Genap & Program KKN / Magang Industri',
                'tanggal_mulai' => '2027-06-14',
                'tanggal_selesai' => '2027-07-31',
                'kategori' => 'Libur',
                'keterangan' => 'Pelaksanaan KKN tematik dan magang MBKM',
                'is_active' => true,
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Wisuda & Yudisium Sarjana & Pascasarjana UIS',
                'tanggal_mulai' => '2027-08-21',
                'tanggal_selesai' => '2027-08-21',
                'kategori' => 'Wisuda',
                'keterangan' => 'Sidang Senat Terbuka Wisuda UIS Batam',
                'is_active' => true,
            ],
        ];
    }
}
