@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola {{ $pageTitle }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik</li>
            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada input form:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('akademik.update', $tipe) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $icons = [
                                    'kurikulum' => 'bi-journal-text text-primary',
                                    'kalender'  => 'bi-calendar-check text-warning',
                                    'pedoman'   => 'bi-book text-success',
                                    'sistem'    => 'bi-laptop text-info',
                                ];
                                $iconClass = $icons[$tipe] ?? 'bi-mortarboard text-primary';
                            @endphp
                            <i class="bi {{ $iconClass }} fs-4"></i>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Formulir Informasi {{ $pageTitle }}</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} onchange="updateKalenderStatusBadge(this.checked)">
                            </div>
                            <span id="kalenderStatusBadge" class="badge rounded-pill px-3 py-1.5 {{ old('is_active', $item->is_active) ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                <i class="bi {{ old('is_active', $item->is_active) ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
                                {{ old('is_active', $item->is_active) ? 'Status: Aktif di Web' : 'Status: Nonaktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- Judul & Subjudul --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label fw-semibold small text-dark">Judul Utama <span class="text-danger">*</span></label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $item->judul) }}" placeholder="Contoh: {{ $pageTitle }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="subjudul" class="form-label fw-semibold small text-dark">Subjudul / Ringkasan</label>
                                <input type="text" id="subjudul" name="subjudul" class="form-control @error('subjudul') is-invalid @enderror" value="{{ old('subjudul', $item->subjudul) }}" placeholder="Keterangan singkat pengantar...">
                            </div>
                        </div>

                        {{-- Link URL / Portal Eksternal (Opsional) --}}
                        <div class="mb-3">
                            <label for="link_url" class="form-label fw-semibold small text-dark">
                                <i class="bi bi-link-45deg text-primary"></i> Link Eksternal / Portal URL <span class="text-muted fw-normal">(Opsional - Terutama untuk SIAKAD/E-Learning)</span>
                            </label>
                            <input type="text" id="link_url" name="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url', $item->link_url) }}" placeholder="https://siakad.uis.ac.id">
                            <div class="form-text small text-muted">Jika diisi, pengunjung yang mengklik menu dapat langsung diarahkan ke portal tersebut.</div>
                        </div>

                        {{-- Deskripsi Konten Lengkap --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold small text-dark">Konten / Keterangan Lengkap</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror" rows="10" placeholder="Tuliskan detail informasi, panduan, jadwal, atau instruksi akademik di sini...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                        </div>

                        @if($tipe === 'kalender')
                        {{-- Pengelola Linimasa Agenda Kalender Akademik (Interaktif & Best Practice) --}}
                        @php
                            $agendas = old('agenda_items', $item->agenda_items ?? []);
                            if (empty($agendas)) {
                                $agendas = [];
                            }
                            $countTotal = count($agendas);
                            $countAktif = collect($agendas)->filter(fn($a) => ($a['is_active'] ?? true))->count();
                            $countNonaktif = $countTotal - $countAktif;
                        @endphp

                        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #fbfdfc; border: 1px solid #d4edda !important;">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="bi bi-calendar-week-fill text-success"></i>
                                            Linimasa Agenda Kalender Akademik (Sifat: Is Active)
                                        </h6>
                                    </div>
                                    <div class="small text-muted">Setiap agenda memiliki sakelar status <strong>Aktif / Nonaktif</strong> agar hanya kegiatan yang disetujui yang tampil pada kalender frontend.</div>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 small fw-semibold">
                                        Total: <strong id="statTotalAgenda">{{ $countTotal }}</strong>
                                    </span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small fw-semibold">
                                        Aktif: <strong id="statAktifAgenda">{{ $countAktif }}</strong>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted rounded-pill px-2.5 py-1 small fw-semibold">
                                        Nonaktif: <strong id="statNonaktifAgenda">{{ $countNonaktif }}</strong>
                                    </span>
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 ms-1 fw-bold" onclick="tambahBarisAgenda()" style="background: #046B26; border-color: #046B26;">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Agenda
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle mb-0" id="tabelAgendaKalender">
                                        <thead class="table-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="text-center" style="width: 75px;">Status</th>
                                                <th style="width: 105px;">Semester</th>
                                                <th>Nama Kegiatan Akademik</th>
                                                <th style="width: 135px;">Tgl Mulai</th>
                                                <th style="width: 135px;">Tgl Selesai</th>
                                                <th style="width: 160px;">Kategori Warna</th>
                                                <th>Keterangan / Lokasi</th>
                                                <th class="text-center" style="width: 50px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyAgenda">
                                            @forelse($agendas as $i => $ag)
                                                @php
                                                    $isRowActive = ($ag['is_active'] ?? true) == true;
                                                @endphp
                                                <tr class="{{ $isRowActive ? '' : 'table-light opacity-75' }}">
                                                    <td class="text-center">
                                                        <div class="form-check form-switch d-inline-block mb-0">
                                                            <input type="hidden" name="agenda_items[{{ $i }}][is_active]" value="0">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="agenda_items[{{ $i }}][is_active]" value="1" {{ $isRowActive ? 'checked' : '' }} onchange="toggleRowActive(this)" title="Aktifkan / Nonaktifkan Agenda Ini">
                                                        </div>
                                                        <div class="small fw-semibold status-row-label" style="font-size: 10px; color: {{ $isRowActive ? '#046B26' : '#6c757d' }};">
                                                            {{ $isRowActive ? 'Aktif' : 'Nonaktif' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <select name="agenda_items[{{ $i }}][semester]" class="form-select form-select-sm">
                                                            <option value="Ganjil" {{ ($ag['semester'] ?? '') === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                            <option value="Genap" {{ ($ag['semester'] ?? '') === 'Genap' ? 'selected' : '' }}>Genap</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="agenda_items[{{ $i }}][kegiatan]" class="form-control form-control-sm" value="{{ $ag['kegiatan'] ?? '' }}" placeholder="Contoh: Registrasi Ulang & KRS" required>
                                                    </td>
                                                    <td>
                                                        <input type="date" name="agenda_items[{{ $i }}][tanggal_mulai]" class="form-control form-control-sm" value="{{ $ag['tanggal_mulai'] ?? '' }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="date" name="agenda_items[{{ $i }}][tanggal_selesai]" class="form-control form-control-sm" value="{{ $ag['tanggal_selesai'] ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <select name="agenda_items[{{ $i }}][kategori]" class="form-select form-select-sm">
                                                            @php
                                                                $katOptions = [
                                                                    'Perkuliahan' => '🟢 Perkuliahan',
                                                                    'Registrasi' => '🔵 Registrasi & KRS',
                                                                    'Ujian' => '🟠 Ujian (UTS/UAS)',
                                                                    'Libur' => '🔴 Libur Semester',
                                                                    'Wisuda' => '🟣 Wisuda / Yudisium',
                                                                    'Akademik' => '🔷 Kegiatan Akademik',
                                                                    'Kemahasiswaan' => '🔶 Kemahasiswaan'
                                                                ];
                                                            @endphp
                                                            @foreach($katOptions as $kVal => $kLabel)
                                                                <option value="{{ $kVal }}" {{ ($ag['kategori'] ?? '') === $kVal ? 'selected' : '' }}>{{ $kLabel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="agenda_items[{{ $i }}][keterangan]" class="form-control form-control-sm" value="{{ $ag['keterangan'] ?? '' }}" placeholder="Catatan / Info portal">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-2" onclick="hapusBarisAgenda(this)" title="Hapus baris">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr id="emptyRowAgenda">
                                                    <td colspan="8" class="text-center py-3 text-muted small">
                                                        Belum ada linimasa agenda. Klik "Tambah Agenda" untuk menambahkan jadwal kegiatan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                        let agendaIndex = {{ count($agendas) }};

                        function updateKalenderStatusBadge(checked) {
                            const badge = document.getElementById('kalenderStatusBadge');
                            if (checked) {
                                badge.className = 'badge rounded-pill px-3 py-1.5 bg-success text-white';
                                badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Status: Aktif di Web';
                            } else {
                                badge.className = 'badge rounded-pill px-3 py-1.5 bg-secondary text-white';
                                badge.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Status: Nonaktif';
                            }
                        }

                        function toggleRowActive(switchEl) {
                            const tr = switchEl.closest('tr');
                            const label = tr.querySelector('.status-row-label');
                            if (switchEl.checked) {
                                tr.classList.remove('table-light', 'opacity-75');
                                if (label) {
                                    label.innerText = 'Aktif';
                                    label.style.color = '#046B26';
                                }
                            } else {
                                tr.classList.add('table-light', 'opacity-75');
                                if (label) {
                                    label.innerText = 'Nonaktif';
                                    label.style.color = '#6c757d';
                                }
                            }
                            recountStats();
                        }

                        function recountStats() {
                            const rows = document.querySelectorAll('#tbodyAgenda tr:not(#emptyRowAgenda)');
                            let total = rows.length;
                            let aktif = 0;
                            rows.forEach(r => {
                                const sw = r.querySelector('input[type="checkbox"]');
                                if (sw && sw.checked) aktif++;
                            });
                            const statTotal = document.getElementById('statTotalAgenda');
                            const statAktif = document.getElementById('statAktifAgenda');
                            const statNonaktif = document.getElementById('statNonaktifAgenda');
                            if (statTotal) statTotal.innerText = total;
                            if (statAktif) statAktif.innerText = aktif;
                            if (statNonaktif) statNonaktif.innerText = (total - aktif);
                        }

                        function tambahBarisAgenda() {
                            const emptyRow = document.getElementById('emptyRowAgenda');
                            if (emptyRow) emptyRow.remove();

                            const tbody = document.getElementById('tbodyAgenda');
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block mb-0">
                                        <input type="hidden" name="agenda_items[${agendaIndex}][is_active]" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" name="agenda_items[${agendaIndex}][is_active]" value="1" checked onchange="toggleRowActive(this)" title="Aktifkan / Nonaktifkan Agenda Ini">
                                    </div>
                                    <div class="small fw-semibold status-row-label" style="font-size: 10px; color: #046B26;">Aktif</div>
                                </td>
                                <td>
                                    <select name="agenda_items[${agendaIndex}][semester]" class="form-select form-select-sm">
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="agenda_items[${agendaIndex}][kegiatan]" class="form-control form-control-sm" placeholder="Nama kegiatan" required>
                                </td>
                                <td>
                                    <input type="date" name="agenda_items[${agendaIndex}][tanggal_mulai]" class="form-control form-control-sm" required>
                                </td>
                                <td>
                                    <input type="date" name="agenda_items[${agendaIndex}][tanggal_selesai]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <select name="agenda_items[${agendaIndex}][kategori]" class="form-select form-select-sm">
                                        <option value="Perkuliahan">🟢 Perkuliahan</option>
                                        <option value="Registrasi">🔵 Registrasi & KRS</option>
                                        <option value="Ujian">🟠 Ujian (UTS/UAS)</option>
                                        <option value="Libur">🔴 Libur Semester</option>
                                        <option value="Wisuda">🟣 Wisuda / Yudisium</option>
                                        <option value="Akademik" selected>🔷 Kegiatan Akademik</option>
                                        <option value="Kemahasiswaan">🔶 Kemahasiswaan</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="agenda_items[${agendaIndex}][keterangan]" class="form-control form-control-sm" placeholder="Catatan / Info portal">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-2" onclick="hapusBarisAgenda(this)" title="Hapus baris">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                            agendaIndex++;
                            recountStats();
                        }

                        function hapusBarisAgenda(btn) {
                            btn.closest('tr').remove();
                            recountStats();
                        }
                        </script>
                        @endif

                        <hr class="my-4 text-muted opacity-25">

                        {{-- Upload Dokumen & Banner --}}
                        <div class="row g-4 mb-3">
                            {{-- Dokumen PDF/Doc --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #faf7fc; border: 1px solid #ebdcf5;">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="bi bi-file-earmark-pdf text-danger me-1"></i> File Dokumen Unduhan (PDF / DOC)
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label for="file_nama" class="form-label fw-semibold small text-dark">Nama Label File</label>
                                        <input type="text" id="file_nama" name="file_nama" class="form-control" value="{{ old('file_nama', $item->file_nama) }}" placeholder="Contoh: Kalender Akademik 2026-2027.pdf">
                                    </div>

                                    <div class="mb-2">
                                        <label for="file_dokumen" class="form-label fw-semibold small text-dark">Upload File Dokumen Baru</label>
                                        <input type="file" id="file_dokumen" name="file_dokumen" class="form-control @error('file_dokumen') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                        <div class="form-text small">Format: PDF, DOC, DOCX, XLS (Maks. 20MB)</div>
                                    </div>

                                    @if($item->file_dokumen)
                                        <div class="mt-3 p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2 text-truncate">
                                                <i class="bi bi-file-earmark-check-fill text-success fs-5"></i>
                                                <span class="small fw-semibold text-truncate">{{ $item->file_nama ?: 'Dokumen Terlampir' }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                                <i class="bi bi-download me-1"></i> Unduh
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Gambar Banner / Cover --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="bi bi-image text-primary me-1"></i> Gambar Banner / Infografis Cover
                                    </h6>

                                    <div class="mb-2">
                                        <label for="gambar" class="form-label fw-semibold small text-dark">Upload Gambar Baru</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                        <div class="form-text small">Format: JPEG, PNG, JPG, WEBP (Maks. 20 MB)</div>
                                    </div>

                                    @if($item->gambar)
                                        <div class="mt-3 text-center p-2 bg-white rounded border">
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;">
                                            <div class="small text-muted mt-1">Gambar saat ini terpasang</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold" style="background: #046B26; border-color: #046B26;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Data {{ $pageTitle }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection
