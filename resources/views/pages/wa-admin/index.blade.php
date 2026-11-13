@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan WA Admin</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan & Administrator</li>
            <li class="breadcrumb-item active">Pengaturan WA Admin</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-whatsapp me-2 text-success"></i>Konfigurasi Tombol Chat WhatsApp Admin
                    </h5>
                    <small class="text-muted">Atur nomor tujuan, label tombol, dan teks pesan otomatis untuk tombol mengambang WhatsApp di pojok kanan bawah website.</small>
                </div>
            </div>
            <div class="card-body pt-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali input Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('wa-admin.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="no_wa" class="form-label fw-semibold">
                                Nomor WhatsApp Admin <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-success"><i class="bi bi-whatsapp"></i></span>
                                <input type="text"
                                       id="no_wa"
                                       name="no_wa"
                                       class="form-control @error('no_wa') is-invalid @enderror"
                                       value="{{ old('no_wa', $setting->no_wa) }}"
                                       placeholder="Contoh: 081270008899 atau 6281270008899"
                                       oninput="updateWaPreview()">
                            </div>
                            <div class="form-text">Gunakan awalan <code>08...</code> atau <code>628...</code> (otomatis diformat ke standar internasional WhatsApp).</div>
                            @error('no_wa')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="label_tombol" class="form-label fw-semibold">
                                Label Tombol Chat <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="label_tombol"
                                   name="label_tombol"
                                   class="form-control @error('label_tombol') is-invalid @enderror"
                                   value="{{ old('label_tombol', $setting->label_tombol) }}"
                                   placeholder="Contoh: Chat WA Admin"
                                   oninput="updateWaPreview()">
                            <div class="form-text">Teks pada tombol di pojok kanan bawah halaman frontend.</div>
                            @error('label_tombol')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama_admin" class="form-label fw-semibold">
                            Judul / Keterangan Layanan (Tooltip)
                        </label>
                        <input type="text"
                               id="nama_admin"
                               name="nama_admin"
                               class="form-control @error('nama_admin') is-invalid @enderror"
                               value="{{ old('nama_admin', $setting->nama_admin) }}"
                               placeholder="Contoh: Admin Universitas Ibnu Sina">
                        @error('nama_admin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pesan_default" class="form-label fw-semibold">
                            Pesan Otomatis Saat Diklik
                        </label>
                        <textarea id="pesan_default"
                                  name="pesan_default"
                                  rows="3"
                                  class="form-control @error('pesan_default') is-invalid @enderror"
                                  placeholder="Tulis teks pembuka otomatis saat pengunjung menghubungi WhatsApp Admin...">{{ old('pesan_default', $setting->pesan_default) }}</textarea>
                        @error('pesan_default')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $setting->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Tampilkan Tombol Chat WA Admin di Frontend
                            </label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Simpan Pengaturan
                        </button>
                        <a href="{{ $setting->wa_url }}" target="_blank" rel="noopener" class="btn btn-outline-success">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Tes Buka Link WhatsApp
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-eye me-2 text-success"></i>Pratinjau Posisi Tombol Frontend
                </h6>
            </div>
            <div class="card-body">
                <div class="rounded-4 p-4 position-relative d-flex flex-column align-items-end justify-content-end" style="background: #033a16; min-height: 230px; border: 1px solid #d1e7dd;">
                    <div class="text-white-50 small position-absolute top-0 start-0 p-3" style="font-size: 11.5px;">
                        Pojok Kanan Bawah Website
                    </div>

                    <!-- Simulasi Back to Top -->
                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 44px; height: 44px; border-radius: 12px; background: #046B26; color: #ffffff; border: 1px solid #FED802;">
                        <i class="bi bi-chevron-up"></i>
                    </div>

                    <!-- Simulasi Tombol Chat WA Admin -->
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 shadow" style="background: #046B26; color: #ffffff; border: 1.5px solid #FED802; border-radius: 12px; font-weight: 700; font-size: 13.5px;">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 26px; height: 26px; background: #25D366; color: #ffffff; font-size: 14px;">
                            <i class="bi bi-whatsapp"></i>
                        </span>
                        <span id="previewWaLabel">{{ $setting->label_tombol }}</span>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    Nomor Aktif: <strong id="previewWaNumber">{{ $setting->clean_wa ?: '-' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateWaPreview() {
        const lbl = document.getElementById('label_tombol')?.value?.trim() || 'Chat WA Admin';
        const num = document.getElementById('no_wa')?.value?.trim() || '-';
        const previewLbl = document.getElementById('previewWaLabel');
        const previewNum = document.getElementById('previewWaNumber');
        if (previewLbl) previewLbl.textContent = lbl;
        if (previewNum) previewNum.textContent = num;
    }
</script>
@endpush

