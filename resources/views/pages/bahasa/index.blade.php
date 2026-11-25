@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Bahasa (Multi-Language)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan & Administrator</li>
            <li class="breadcrumb-item active">Pengaturan Bahasa</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 col-xl-11">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Info Box --}}
        <div class="alert alert-info d-flex align-items-start gap-3 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #e8f4fd; border-color: #b8e0fe; color: #0c5460;">
            <i class="bi bi-translate fs-3 text-primary mt-1"></i>
            <div>
                <h6 class="fw-bold mb-1">Pengaturan Menu Pilih Bahasa (Penerjemah Otomatis Website)</h6>
                <p class="mb-1 small">
                    Daftar bahasa di bawah ini akan ditampilkan pada <strong>dropdown pilih bahasa di samping menu Kontak</strong> pada navigasi website. 
                    Ketika pengunjung memilih salah satu bahasa, <strong>seluruh konten teks, menu, berita, dan nama</strong> di halaman website akan otomatis diterjemahkan secara langsung ke bahasa tersebut.
                </p>
                <div class="small mt-2 pt-2 border-top border-info-subtle">
                    <i class="bi bi-check-circle-fill text-success me-1"></i><strong>Logo Bendera Otomatis:</strong> Cukup masukkan <strong>Kode Negara</strong> (seperti <code>ps</code> untuk Palestina, <code>id</code> untuk Indonesia, <code>gb</code> untuk Inggris, <code>sa</code> untuk Arab Saudi), bendera resmi akan otomatis dibuat dan ditampilkan tanpa perlu repot upload file.
                </div>
            </div>
        </div>

        {{-- Quick Stats Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; border-left: 4px solid #046B26 !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold">Total Bahasa</span>
                                <h4 class="mb-0 fw-bold mt-1 text-dark">{{ $bahasas->count() }}</h4>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eaf6ee; color: #046B26;">
                                <i class="bi bi-globe2 fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; border-left: 4px solid #28a745 !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold">Bahasa Aktif</span>
                                <h4 class="mb-0 fw-bold mt-1 text-success">{{ $bahasas->where('is_active', true)->count() }}</h4>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #d4edda; color: #28a745;">
                                <i class="bi bi-check-circle fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; border-left: 4px solid #FED802 !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold">Bahasa Default</span>
                                @php
                                    $def = $bahasas->firstWhere('is_default', true);
                                @endphp
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    @if($def)
                                        <img src="{{ $def->flag_url }}" alt="Flag" width="22" height="15" class="rounded border shadow-sm" style="object-fit: cover;">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $def->nama }}</h6>
                                    @else
                                        <h6 class="mb-0 fw-bold text-dark">Indonesia</h6>
                                    @endif
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fefde8; color: #b45309;">
                                <i class="bi bi-star-fill fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; border-left: 4px solid #0d6efd !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold">Mesin Translate</span>
                                <h6 class="mb-0 fw-bold mt-1 text-primary">Google Engine</h6>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e7f1ff; color: #0d6efd;">
                                <i class="bi bi-cpu fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Batch Update Urutan & Status --}}
        <form action="{{ route('bahasa.update-all') }}" method="POST">
            @csrf

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 16px;">
                        <i class="bi bi-list-check me-2" style="color: #046B26;"></i>Daftar Bahasa Website
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('homepage') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Preview di Navbar
                        </a>
                        <button type="button" class="btn btn-sm fw-semibold shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalAddBahasa" style="background: #046B26; border-color: #046B26;">
                            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Bahasa Baru
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;" class="text-center">Urutan</th>
                                    <th style="width: 80px;" class="text-center">Bendera</th>
                                    <th>Nama Bahasa</th>
                                    <th>Kode</th>
                                    <th style="width: 130px;" class="text-center">Status Navbar</th>
                                    <th style="width: 140px;" class="text-center">Default</th>
                                    <th style="width: 160px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bahasas as $b)
                                    <tr class="{{ $b->is_default ? 'table-warning-subtle' : '' }}">
                                        {{-- Input Urutan --}}
                                        <td class="text-center">
                                            <input type="number" 
                                                   name="bahasas[{{ $b->id }}][urutan]" 
                                                   value="{{ $b->urutan }}" 
                                                   class="form-control form-control-sm text-center mx-auto" 
                                                   style="width: 65px; border-color: #ced4da;" 
                                                   min="1">
                                        </td>

                                        {{-- Bendera --}}
                                        <td class="text-center">
                                            <img src="{{ $b->flag_url }}" 
                                                 alt="{{ $b->nama }}" 
                                                 width="28" 
                                                 height="19" 
                                                 class="rounded border shadow-sm" 
                                                 style="object-fit: cover;"
                                                 onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
                                        </td>

                                        {{-- Nama Bahasa --}}
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold text-dark">{{ $b->nama }}</span>
                                                @if($b->is_default)
                                                    <span class="badge bg-warning text-dark fw-semibold" style="font-size: 10px;">
                                                        <i class="bi bi-star-fill me-1"></i>Default
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-1 small">
                                                @if($b->tipe_bendera === 'upload')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle py-1 px-2" style="font-size: 10px;">
                                                        <i class="bi bi-image me-1"></i>Bendera: Upload Gambar
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-secondary border py-1 px-2" style="font-size: 10px;">
                                                        <i class="bi bi-flag me-1"></i>Bendera: Kode ({{ $b->kode_negara ?: $b->kode }})
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Kode --}}
                                        <td>
                                            <code class="px-2 py-1 bg-light text-dark rounded border fw-bold" style="font-size: 12px;">{{ $b->kode }}</code>
                                        </td>

                                        {{-- Status Aktif Switch --}}
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="bahasas[{{ $b->id }}][is_active]" 
                                                       value="1" 
                                                       id="switch_{{ $b->id }}"
                                                       {{ $b->is_active ? 'checked' : '' }}
                                                       {{ $b->is_default ? 'disabled checked' : '' }}
                                                       title="{{ $b->is_default ? 'Bahasa default tidak bisa dinonaktifkan' : 'Klik untuk mengubah status' }}">
                                                @if($b->is_default)
                                                    <input type="hidden" name="bahasas[{{ $b->id }}][is_active]" value="1">
                                                @endif
                                            </div>
                                            <div class="small">
                                                @if($b->is_active)
                                                    <span class="text-success fw-semibold" style="font-size: 11px;">Aktif</span>
                                                @else
                                                    <span class="text-muted" style="font-size: 11px;">Nonaktif</span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Tombol Jadikan Default --}}
                                        <td class="text-center">
                                            @if($b->is_default)
                                                <span class="badge bg-success py-2 px-3 fw-normal" style="font-size: 11px;">
                                                    <i class="bi bi-check2-circle me-1"></i> Utama
                                                </span>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-warning py-1 px-2 text-dark" 
                                                        onclick="submitSetDefault('{{ route('bahasa.set-default', $b->id) }}', '{{ $b->nama }}')"
                                                        title="Jadikan sebagai bahasa default website"
                                                        style="font-size: 11px;">
                                                    <i class="bi bi-star me-1"></i> Set Default
                                                </button>
                                            @endif
                                        </td>

                                        {{-- Aksi Edit & Hapus --}}
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary py-1 px-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditBahasa{{ $b->id }}"
                                                        title="Edit Data Bahasa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                @if(!$b->is_default)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger py-1 px-2" 
                                                            onclick="confirmDeleteBahasa('{{ route('bahasa.destroy', $b->id) }}', '{{ $b->nama }}')"
                                                            title="Hapus Bahasa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            Belum ada data bahasa. Silakan klik tombol "Tambah Bahasa Baru".
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-radius: 0 0 12px 12px;">
                    <div class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i> Ubah urutan angka atau aktifkan switch, kemudian klik tombol <strong>Simpan Perubahan</strong>.
                    </div>
                    <button type="submit" class="btn fw-semibold text-white px-4 shadow-sm" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan Urutan & Status
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- MODAL TAMBAH BAHASA --}}
<div class="modal fade" id="modalAddBahasa" tabindex="-1" aria-labelledby="modalAddBahasaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('bahasa.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header text-white" style="background: #046B26; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold" id="modalAddBahasaLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Bahasa Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Bahasa <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Palestina, Türkçe, Español, dll." required>
                        <small class="text-muted">Nama bahasa dalam bahasa aslinya.</small>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-1" style="min-height: 24px;">Kode Bahasa (Google) <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" placeholder="Contoh: ar, id, en, tr" required>
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Standar ISO 639-1 (misal: <code>ar</code>, <code>id</code>, <code>en</code>, <code>tr</code>)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-1" style="min-height: 24px;">Kode Bendera (Negara) <span class="text-danger">*</span></label>
                            <input type="text" name="kode_negara" class="form-control" placeholder="Contoh: ps, id, gb, tr" required oninput="updateLiveFlag(this.value, 'add_flag_preview')">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Bisa ISO (<code>ps</code>, <code>id</code>) atau FIFA (<code>PLE</code>, <code>INA</code>)</small>
                        </div>
                    </div>

                    {{-- Live Preview Bendera Otomatis --}}
                    <div class="mb-3 p-3 bg-light rounded border d-flex align-items-center gap-3">
                        <img id="add_flag_preview" src="{{ asset('assets/img/flags/id.png') }}" width="36" height="24" class="rounded border shadow-sm" style="object-fit: cover;" onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
                        <div>
                            <span class="fw-semibold text-dark d-block small">Preview Logo Bendera Otomatis</span>
                            <span class="text-muted" style="font-size: 11px;">Bendera resmi otomatis dibuatkan dan ditampilkan saat Anda mengetik kode negara.</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ ($bahasas->max('urutan') ?? 0) + 1 }}" min="1">
                        </div>
                        <div class="col-md-6 d-flex align-items-center pt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add_is_active" checked>
                                <label class="form-check-label fw-semibold ms-1" for="add_is_active">Aktif di navbar</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white fw-semibold" style="background: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Bahasa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT BAHASA (LOOP PER ITEM) --}}
@foreach ($bahasas as $b)
<div class="modal fade" id="modalEditBahasa{{ $b->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('bahasa.update', $b->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header bg-primary text-white" style="border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Edit Bahasa: {{ $b->nama }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Logo Bendera Saat Ini --}}
                    <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded border">
                        <img src="{{ $b->flag_url }}" 
                             id="edit_flag_preview_{{ $b->id }}" 
                             alt="Flag" 
                             width="40" 
                             height="26" 
                             class="rounded border shadow-sm" 
                             style="object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
                        <div>
                            <span class="fw-bold text-dark d-block" style="font-size: 13px;">Logo Bendera: {{ $b->nama }}</span>
                            <span class="small text-muted" style="font-size: 11px;">Kode Negara: <code>{{ $b->kode_negara ?: $b->kode }}</code> (Bendera Otomatis)</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Bahasa <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ $b->nama }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-1" style="min-height: 24px;">Kode Bahasa (Google) <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" value="{{ $b->kode }}" required>
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Standar ISO 639-1 (misal: <code>ar</code>, <code>id</code>, <code>en</code>, <code>tr</code>)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-1" style="min-height: 24px;">Kode Bendera (Negara) <span class="text-danger">*</span></label>
                            <input type="text" name="kode_negara" class="form-control" value="{{ $b->kode_negara ?: $b->kode }}" required oninput="updateLiveFlag(this.value, 'edit_flag_preview_{{ $b->id }}')">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Bisa ISO (<code>ps</code>, <code>id</code>) atau FIFA (<code>PLE</code>, <code>INA</code>)</small>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ $b->urutan }}" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- Hidden Form for Delete & Set Default --}}
<form id="action-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" id="action-method" value="POST">
</form>

@push('scripts')
<script>
    function updateLiveFlag(code, imgId) {
        var img = document.getElementById(imgId);
        if (!img) return;
        var clean = (code || '').trim().toLowerCase();
        if (!clean) return;

        var map = {
            'ple': 'ps', 'pse': 'ps', 'palestina': 'ps', 'palestine': 'ps',
            'ina': 'id', 'idn': 'id', 'indonesia': 'id',
            'gbr': 'gb', 'eng': 'gb', 'uk': 'gb', 'en': 'gb',
            'ksa': 'sa', 'sau': 'sa', 'ar': 'sa',
            'usa': 'us', 'tur': 'tr', 'esp': 'es', 'ger': 'de', 'deu': 'de',
            'fra': 'fr', 'ned': 'nl', 'nld': 'nl', 'phi': 'ph', 'phl': 'ph',
            'ind': 'in', 'ita': 'it', 'jpn': 'jp', 'kor': 'kr', 'chn': 'cn',
            'mas': 'my', 'mys': 'my', 'sin': 'sg', 'sgp': 'sg'
        };
        if (map[clean]) clean = map[clean];

        img.src = 'https://flagcdn.com/w40/' + clean + '.png';
    }

    function submitSetDefault(url, nama) {
        if (confirm('Jadikan "' + nama + '" sebagai bahasa default website?')) {
            const form = document.getElementById('action-form');
            form.action = url;
            document.getElementById('action-method').value = 'POST';
            form.submit();
        }
    }

    function confirmDeleteBahasa(url, nama) {
        if (confirm('Apakah Anda yakin ingin menghapus bahasa "' + nama + '"?')) {
            const form = document.getElementById('action-form');
            form.action = url;
            document.getElementById('action-method').value = 'DELETE';
            form.submit();
        }
    }
</script>
@endpush

@endsection
