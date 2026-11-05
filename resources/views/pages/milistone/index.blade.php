@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Sejarah & Milestone Universitas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Sejarah Universitas</li>
        </ol>
    </nav>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Pengaturan Narasi Sejarah & Kartu Fokus Institusi -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-journal-text me-2 text-success"></i>Pengaturan Narasi Sejarah Universitas
                </h5>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNarasiSejarah" aria-expanded="true">
                    <i class="bi bi-sliders me-1"></i> Tampilkan / Sembunyikan Form
                </button>
            </div>
            <div id="collapseNarasiSejarah" class="collapse show">
                <div class="card-body pt-4">
                    <form action="{{ route('milestone.update-setting') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Kolom Kiri: Narasi Sejarah -->
                            <div class="col-lg-6">
                                <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bi bi-text-left me-1"></i> Bagian Kiri: Jejak Langkah & Narasi Sejarah
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Label Badge Atas</label>
                                        <input type="text" name="sejarah_label" class="form-control"
                                               value="{{ old('sejarah_label', $about?->sejarah_label ?: 'Jejak Langkah Universitas') }}"
                                               placeholder="Jejak Langkah Universitas">
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Judul Utama (Teks Biasa)</label>
                                            <input type="text" name="sejarah_judul" class="form-control"
                                                   value="{{ old('sejarah_judul', $about?->sejarah_judul ?: 'Perjalanan Berkelanjutan') }}"
                                                   placeholder="Perjalanan Berkelanjutan">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Judul Highlight (Warna Hijau)</label>
                                            <input type="text" name="sejarah_judul_highlight" class="form-control"
                                                   value="{{ old('sejarah_judul_highlight', $about?->sejarah_judul_highlight ?: 'Mencetak Profesional Muda') }}"
                                                   placeholder="Mencetak Profesional Muda">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Paragraf Narasi 1</label>
                                        <textarea name="sejarah_deskripsi_1" rows="4" class="form-control">{{ old('sejarah_deskripsi_1', $about?->sejarah_deskripsi_1 ?: 'Universitas Ibnu Sina (UIS) Batam berdiri dari tonggak sejarah panjang pengabdian Yayasan Pendidikan Ibnu Sina Batam (YAPISNA) sejak tahun 1993 dalam memajukan kualitas sumber daya manusia di kawasan strategis perbatasan Kepulauan Riau.') }}</textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold small">Paragraf Narasi 2</label>
                                        <textarea name="sejarah_deskripsi_2" rows="4" class="form-control">{{ old('sejarah_deskripsi_2', $about?->sejarah_deskripsi_2 ?: 'Melalui penggabungan tiga institusi pendidikan tinggi terkemuka—Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES)—lembaga ini resmi bertransformasi menjadi Universitas Ibnu Sina berdasarkan Surat Keputusan Menristekdikti RI. Kini UIS menaungi Fakultas Teknik, Fakultas Ekonomi & Bisnis (FEB), Fakultas Ilmu Kesehatan (FIKES), dan Program Pascasarjana.') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Kartu Fokus Institusi -->
                            <div class="col-lg-6">
                                <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bi bi-card-heading me-1"></i> Bagian Kanan: Kartu Fokus Institusi
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Judul Kartu</label>
                                        <input type="text" name="sejarah_card_judul" class="form-control"
                                               value="{{ old('sejarah_card_judul', $about?->sejarah_card_judul ?: 'Kampusnya Profesional Muda') }}"
                                               placeholder="Kampusnya Profesional Muda">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Subjudul Kartu</label>
                                        <input type="text" name="sejarah_card_subjudul" class="form-control"
                                               value="{{ old('sejarah_card_subjudul', $about?->sejarah_card_subjudul ?: 'Pendidikan, Riset Terapan & Kemitraan Industri Global') }}"
                                               placeholder="Pendidikan, Riset Terapan & Kemitraan Industri Global">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Kutipan / Narasi Dalam Kartu</label>
                                        <textarea name="sejarah_card_narasi" rows="4" class="form-control">{{ old('sejarah_card_narasi', $about?->sejarah_card_narasi ?: 'Setiap fase perkembangan Universitas Ibnu Sina diarahkan untuk memperkuat mutu pembelajaran berbasis teknologi informasi, riset terapan bernilai guna bagi industri manufaktur dan maritim, serta membentuk lulusan berjiwa entrepreneur berbasis Imtaq.') }}</textarea>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 1</label>
                                            <input type="text" name="sejarah_pilar_1" class="form-control"
                                                   value="{{ old('sejarah_pilar_1', $about?->sejarah_pilar_1 ?: 'Teknologi Informasi') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 2</label>
                                            <input type="text" name="sejarah_pilar_2" class="form-control"
                                                   value="{{ old('sejarah_pilar_2', $about?->sejarah_pilar_2 ?: 'Industri & Maritim') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 3</label>
                                            <input type="text" name="sejarah_pilar_3" class="form-control"
                                                   value="{{ old('sejarah_pilar_3', $about?->sejarah_pilar_3 ?: 'Entrepreneur & Imtaq') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Simpan Narasi Sejarah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Milestone -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Daftar Milestone
                </h5>
                <a href="{{ route('milestone.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Milestone
                </a>
            </div>
            <div class="card-body pt-4">
                {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle']) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
