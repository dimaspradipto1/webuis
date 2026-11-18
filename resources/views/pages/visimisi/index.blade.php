@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">Visi & Misi</li>
        </ol>
    </nav>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     CARD 1: PENGATURAN TEKS HEADER HALAMAN
     ═══════════════════════════════════════════════════════════════ --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                <i class="bi bi-pencil-square fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Pengaturan Teks Header Halaman</h5>
                <small class="text-muted">Edit label kecil, judul utama, dan kalimat pengantar yang tampil di atas gambar Visi & Misi</small>
            </div>
        </div>
        <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-outline-success btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Frontend
        </a>
    </div>
    <div class="card-body pt-3 pb-4">
        <form action="{{ route('visimisi.update-header') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-4 col-12">
                    <label for="visimisi_label" class="form-label fw-bold text-dark small">
                        Label Kecil Atas <small class="text-muted fw-normal">(Badge Kategori)</small>
                    </label>
                    <input type="text"
                           id="visimisi_label"
                           name="visimisi_label"
                           class="form-control @error('visimisi_label') is-invalid @enderror"
                           value="{{ old('visimisi_label', $about->visimisi_label ?? 'Arah & Landasan Institusi') }}"
                           placeholder="Contoh: Arah & Landasan Institusi">
                    <div class="form-text text-muted small">Teks kecil di dalam badge bulat atas.</div>
                    @error('visimisi_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8 col-12">
                    <label for="visimisi_judul" class="form-label fw-bold text-dark small">
                        Judul Utama Halaman <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="visimisi_judul"
                           name="visimisi_judul"
                           class="form-control @error('visimisi_judul') is-invalid @enderror"
                           value="{{ old('visimisi_judul', $about->visimisi_judul ?? 'Visi & Misi Universitas Ibnu Sina') }}"
                           placeholder="Contoh: Visi & Misi Universitas Ibnu Sina"
                           required>
                    <div class="form-text text-muted small">Judul besar di bawah label.</div>
                    @error('visimisi_judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="visimisi_deskripsi" class="form-label fw-bold text-dark small">
                    Paragraf Pengantar / Deskripsi Ringkas
                </label>
                <textarea id="visimisi_deskripsi"
                          name="visimisi_deskripsi"
                          rows="2"
                          class="form-control @error('visimisi_deskripsi') is-invalid @enderror"
                          placeholder="Komitmen fundamental yang mengarahkan setiap langkah Tri Dharma Perguruan Tinggi di Universitas Ibnu Sina.">{{ old('visimisi_deskripsi', $about->visimisi_deskripsi ?? 'Komitmen fundamental yang mengarahkan setiap langkah Tri Dharma Perguruan Tinggi di Universitas Ibnu Sina.') }}</textarea>
                <div class="form-text text-muted small">Kalimat keterangan yang tampil di bawah judul utama.</div>
                @error('visimisi_deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                    <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan Teks
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     CARD 2: DAFTAR GAMBAR VISI & MISI (3 KOLOM FRONTEND)
     ═══════════════════════════════════════════════════════════════ --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                <i class="bi bi-images fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Daftar Gambar Visi & Misi</h5>
                <small class="text-muted">Setiap gambar akan disusun dalam 3 kolom dengan lebar penuh (Full Width 100%) di frontend</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('visimisi.create') }}" class="btn btn-success btn-sm fw-semibold" style="background-color: #046B26; border-color: #046B26;">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Gambar Baru
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-hover table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
