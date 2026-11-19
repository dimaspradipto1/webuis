<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsExcelService
{
    /**
     * Generate and stream download Excel template for importing news.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;

        // -------------------------------------------------------------
        // SHEET 1: DATA BERITA
        // -------------------------------------------------------------
        $sheetData = $spreadsheet->getActiveSheet();
        $sheetData->setTitle('Data Berita');

        $headers = [
            'A1' => 'No',
            'B1' => 'Judul Berita *',
            'C1' => 'Kategori *',
            'D1' => 'Status *',
            'E1' => 'Artikel Unggulan',
            'F1' => 'Deskripsi Singkat *',
            'G1' => 'Konten Berita *',
            'H1' => 'Thumbnail (Boleh Dikosongkan)',
        ];

        foreach ($headers as $cell => $text) {
            $sheetData->setCellValue($cell, $text);
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '046B26'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '023814'],
                ],
            ],
        ];
        $sheetData->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheetData->getRowDimension(1)->setRowHeight(32);

        $sampleData = [
            [
                1,
                'Mahasiswa UIS Berhasil Meraih Juara 1 Kompetisi Inovasi Nasional 2026',
                'Berita Universitas',
                'published',
                'Ya',
                'Prestasi membanggakan kembali ditorehkan mahasiswa Universitas Ibnu Sina dalam kompetisi inovasi tingkat nasional.',
                '<p>Universitas Ibnu Sina kembali menorehkan prestasi gemilang di tingkat nasional. Tim mahasiswa berhasil meraih juara pertama setelah menyisihkan puluhan kampus lainnya dalam ajang inovasi teknologi terapan...</p>',
                '',
            ],
            [
                2,
                'Pelatihan dan Simulasi Penerapan Manajemen K3 di Laboratorium Terpadu',
                'K3 & Lingkungan Industri',
                'published',
                'Tidak',
                'Peningkatan standar keselamatan dan kesehatan kerja lingkungan laboratorium bagi sivitas akademika UIS.',
                '<p>Fakultas menyelenggarakan workshop praktis mengenai keselamatan dan kesehatan kerja di lingkungan kampus untuk menjamin kenyamanan dan standar operasional laboratorium...</p>',
                '',
            ],
        ];

        $rowNum = 2;
        foreach ($sampleData as $row) {
            $sheetData->setCellValue('A'.$rowNum, $row[0]);
            $sheetData->setCellValue('B'.$rowNum, $row[1]);
            $sheetData->setCellValue('C'.$rowNum, $row[2]);
            $sheetData->setCellValue('D'.$rowNum, $row[3]);
            $sheetData->setCellValue('E'.$rowNum, $row[4]);
            $sheetData->setCellValue('F'.$rowNum, $row[5]);
            $sheetData->setCellValue('G'.$rowNum, $row[6]);
            $sheetData->setCellValue('H'.$rowNum, $row[7]);

            $sheetData->getStyle("A{$rowNum}:H{$rowNum}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D0D5DD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheetData->getStyle("A{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheetData->getStyle("C{$rowNum}:E{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheetData->getRowDimension($rowNum)->setRowHeight(28);
            $rowNum++;
        }

        $sheetData->getColumnDimension('A')->setWidth(8);
        $sheetData->getColumnDimension('B')->setWidth(45);
        $sheetData->getColumnDimension('C')->setWidth(28);
        $sheetData->getColumnDimension('D')->setWidth(16);
        $sheetData->getColumnDimension('E')->setWidth(20);
        $sheetData->getColumnDimension('F')->setWidth(45);
        $sheetData->getColumnDimension('G')->setWidth(55);
        $sheetData->getColumnDimension('H')->setWidth(32);

        // -------------------------------------------------------------
        // SHEET 2: PETUNJUK & PANDUAN
        // -------------------------------------------------------------
        $sheetGuide = $spreadsheet->createSheet();
        $sheetGuide->setTitle('Petunjuk & Panduan');

        $sheetGuide->setCellValue('A1', 'PANDUAN & PETUNJUK PENGISIAN IMPORT BERITA UIS');
        $sheetGuide->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('046B26');
        $sheetGuide->getRowDimension(1)->setRowHeight(26);

        $sheetGuide->setCellValue('A2', '* Sheet ini hanya sebagai panduan referensi pengisian data dan tidak akan diimpor ke sistem.');
        $sheetGuide->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->getColor()->setRGB('777777');

        $guideData = [
            ['No', 'Nama Kolom', 'Keterangan & Aturan Pengisian'],
            ['1', 'Judul Berita *', 'WAJIB diisi. Maksimal 250 karakter. Judul berita yang informatif dan menarik.'],
            ['2', 'Kategori *', 'WAJIB diisi salah satu dari: "Berita Universitas", "Berita Humas", "Prestasi Mahasiswa", "Akademik & Kemahasiswaan", "Teknologi & Rekayasa", "Bisnis & Manajemen", "K3 & Lingkungan Industri", "Penelitian & Riset", "Pengabdian Masyarakat", "Kerjasama Industri", atau "Pengumuman & Agenda".'],
            ['3', 'Status *', 'WAJIB diisi. Pilihan: "published" (langsung tampil ke publik) atau "draft" (disimpan sebagai draf).'],
            ['4', 'Artikel Unggulan', 'Pilihan: "Ya" (ditampilkan di banner sorotan utama) atau "Tidak". Default: Tidak.'],
            ['5', 'Deskripsi Singkat *', 'WAJIB diisi ringkasan/kutipan berita (maks 1000 karakter). Jika kosong, sistem otomatis mengambil cuplikan dari Konten Berita.'],
            ['6', 'Konten Berita *', 'WAJIB diisi isi lengkap artikel. Boleh teks biasa maupun format paragraf HTML (<p>...</p>).'],
            ['7', 'Thumbnail', 'OPSIONAL / BOLEH DIKOSONGKAN. Jika dikosongkan, berita akan menggunakan logo bawaan. Anda dapat mengunggah cover foto kemudian melalui menu Edit Berita.'],
        ];

        $gRow = 4;
        foreach ($guideData as $idx => $r) {
            $sheetGuide->setCellValue("A{$gRow}", $r[0]);
            $sheetGuide->setCellValue("B{$gRow}", $r[1]);
            $sheetGuide->setCellValue("C{$gRow}", $r[2]);

            if ($idx === 0) {
                $sheetGuide->getStyle("A{$gRow}:C{$gRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '03521d']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheetGuide->getRowDimension($gRow)->setRowHeight(26);
            } else {
                $sheetGuide->getStyle("A{$gRow}:C{$gRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D0D5DD']]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheetGuide->getStyle("A{$gRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheetGuide->getRowDimension($gRow)->setRowHeight(24);
            }
            $gRow++;
        }

        $sheetGuide->getColumnDimension('A')->setWidth(8);
        $sheetGuide->getColumnDimension('B')->setWidth(26);
        $sheetGuide->getColumnDimension('C')->setWidth(80);

        $spreadsheet->setActiveSheetIndex(0);

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'Template_Import_Post_Berita_UIS.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export all news data to an Excel (.xlsx) file.
     */
    public function exportExcel(?int $onlyUserId = null): StreamedResponse
    {
        $query = News::with('user')->latest('id');
        if ($onlyUserId !== null) {
            $query->where('user_id', $onlyUserId);
        }
        $newsList = $query->get();

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Berita');

        $headers = [
            'A1' => 'No',
            'B1' => 'Judul Berita *',
            'C1' => 'Kategori *',
            'D1' => 'Status *',
            'E1' => 'Artikel Unggulan',
            'F1' => 'Deskripsi Singkat *',
            'G1' => 'Konten Berita *',
            'H1' => 'Thumbnail',
            'I1' => 'Caption Thumbnail',
            'J1' => 'Tanggal Terbit',
            'K1' => 'Penulis',
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '046B26'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '023814'],
                ],
            ],
        ];
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(32);

        $rowNum = 2;
        foreach ($newsList as $idx => $item) {
            $pubDate = $item->published_at ?? $item->created_at;
            $cleanDesc = trim(strip_tags((string) $item->description));
            $cleanContent = trim(html_entity_decode(strip_tags((string) $item->content), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

            $sheet->setCellValue('A'.$rowNum, $idx + 1);
            $sheet->setCellValue('B'.$rowNum, (string) $item->title);
            $sheet->setCellValue('C'.$rowNum, (string) ($item->category ?: 'Berita Universitas'));
            $sheet->setCellValue('D'.$rowNum, (string) ($item->status ?: 'published'));
            $sheet->setCellValue('E'.$rowNum, $item->is_featured ? 'Ya' : 'Tidak');
            $sheet->setCellValue('F'.$rowNum, $cleanDesc);
            $sheet->setCellValue('G'.$rowNum, $cleanContent);
            $sheet->setCellValue('H'.$rowNum, (string) ($item->thumbnail ?? ''));
            $sheet->setCellValue('I'.$rowNum, (string) ($item->thumbnail_caption ?? ''));
            $sheet->setCellValue('J'.$rowNum, $pubDate ? $pubDate->format('Y-m-d H:i:s') : '');
            $sheet->setCellValue('K'.$rowNum, $item->user?->name ?? 'admin');

            $sheet->getStyle("A{$rowNum}:K{$rowNum}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D0D5DD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getStyle("A{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$rowNum}:E{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J{$rowNum}:K{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($rowNum)->setRowHeight(28);
            $rowNum++;
        }

        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(48);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(45);
        $sheet->getColumnDimension('G')->setWidth(60);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(35);
        $sheet->getColumnDimension('J')->setWidth(22);
        $sheet->getColumnDimension('K')->setWidth(18);

        $filename = 'Export_Post_Berita_UIS_'.date('Y-m-d_His').'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Import news data from uploaded spreadsheet file.
     *
     * @throws \Exception
     */
    public function importExcel(UploadedFile $file, int $userId): int
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getSheet(0);
        $rows = $sheet->toArray(null, true, true, true);

        if (count($rows) <= 1) {
            throw new \Exception('File Excel kosong atau tidak memiliki data.');
        }

        $validCategories = [
            'Berita Universitas',
            'Berita Humas',
            'Akademik & Kemahasiswaan',
            'Teknologi & Rekayasa',
            'Bisnis & Manajemen',
            'K3 & Lingkungan Industri',
            'Penelitian & Riset',
            'Pengabdian Masyarakat',
            'Kerjasama Industri',
            'Pengumuman & Agenda',
        ];

        return DB::transaction(function () use ($rows, $userId, $validCategories) {
            $importedCount = 0;

            foreach ($rows as $index => $row) {
                if ($index === 1) {
                    continue;
                }

                $colA = trim((string) ($row['A'] ?? ''));
                $title = trim((string) ($row['B'] ?? ''));

                if ($title === '') {
                    continue;
                }

                if (
                    str_starts_with(strtoupper($title), 'PETUNJUK') ||
                    str_starts_with(strtoupper($title), 'CATATAN') ||
                    str_starts_with(strtoupper($title), 'PANDUAN') ||
                    preg_match('/^\d+\.\s*(Kolom|Anda|Petunjuk|Format|Kategori|Status|Gambar)/i', $title) ||
                    stripos($title, 'WAJIB diisi') !== false ||
                    stripos($title, 'Kolom Kategori dapat diisi') !== false ||
                    stripos($title, 'Kolom Status dapat diisi') !== false ||
                    stripos($title, 'Kolom Artikel Unggulan') !== false ||
                    stripos($title, 'Kolom Thumbnail') !== false
                ) {
                    break;
                }

                if (! is_numeric($colA) && empty($row['C']) && empty($row['D'])) {
                    continue;
                }

                if (mb_strlen($title) > 250) {
                    $title = mb_substr($title, 0, 250);
                }

                $rawCategory = trim((string) ($row['C'] ?? ''));
                $rawStatus = strtolower(trim((string) ($row['D'] ?? '')));
                $rawFeatured = strtolower(trim((string) ($row['E'] ?? '')));
                $description = trim((string) ($row['F'] ?? ''));
                $content = trim((string) ($row['G'] ?? ''));
                $thumbnail = trim((string) ($row['H'] ?? ''));
                $thumbnailCaption = trim((string) ($row['I'] ?? ''));

                $category = 'Berita Universitas';
                if (! empty($rawCategory)) {
                    foreach ($validCategories as $validCat) {
                        if (strcasecmp($validCat, $rawCategory) === 0 || stripos($validCat, $rawCategory) !== false || stripos($rawCategory, $validCat) !== false) {
                            $category = $validCat;
                            break;
                        }
                    }
                }

                $status = str_contains($rawStatus, 'draft') ? 'draft' : 'published';
                $isFeatured = in_array($rawFeatured, ['ya', 'y', '1', 'true', 'yes'], true);

                if (empty($content) && ! empty($description)) {
                    $content = '<p>'.nl2br(e($description)).'</p>';
                } elseif (! empty($content) && ! str_starts_with($content, '<')) {
                    $content = '<p>'.nl2br(e($content)).'</p>';
                }

                if (empty($description)) {
                    $description = Str::limit(strip_tags($content ?: $title), 200);
                }

                if (mb_strlen($description) > 1000) {
                    $description = mb_substr($description, 0, 1000);
                }

                if (empty($content)) {
                    $content = '<p>'.e($title).'</p>';
                }

                $thumbnailPath = null;
                if (! empty($thumbnail) && Storage::disk('public')->exists($thumbnail)) {
                    $thumbnailPath = $thumbnail;
                }

                News::create([
                    'user_id' => $userId,
                    'thumbnail' => $thumbnailPath,
                    'thumbnail_caption' => !empty($thumbnailCaption) && !preg_match('/^\d{4}-\d{2}-\d{2}/', $thumbnailCaption) ? $thumbnailCaption : null,
                    'gallery' => null,
                    'title' => $title,
                    'description' => $description,
                    'content' => $content,
                    'status' => $status,
                    'category' => $category,
                    'is_featured' => $isFeatured,
                    'published_at' => now(),
                ]);

                $importedCount++;
            }

            return $importedCount;
        });
    }
}
