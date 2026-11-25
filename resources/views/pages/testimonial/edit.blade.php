@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Testimoni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimoni</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Testimoni Alumni & Civitas
                </h5>
            </div>
            <div class="card-body pt-4">

                {{-- Error Summary --}}
                @if ($errors->any())
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

                <form action="{{ route('testimonial.update', $testimonial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        {{-- Nama (wajib) --}}
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">
                                Nama Lengkap & Gelar <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $testimonial->nama) }}"
                                   placeholder="Contoh: Ir. Budi Nugraha, S.T., M.Kom / Ns. Siti Rahma, S.Kep"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pekerjaan / Tempat Bekerja (wajib) --}}
                        <div class="col-md-6">
                            <label for="pekerjaan" class="form-label fw-semibold">
                                Profesi / Jabatan / Tempat Bekerja <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="pekerjaan"
                                   name="pekerjaan"
                                   class="form-control @error('pekerjaan') is-invalid @enderror"
                                   value="{{ old('pekerjaan', $testimonial->pekerjaan) }}"
                                   placeholder="Contoh: Software Engineer di PT Telkom / Perawat di RSUD"
                                   required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Kategori (wajib) --}}
                        <div class="col-md-6">
                            <label for="kategori" class="form-label fw-semibold">
                                Kategori Profil <span class="text-danger">*</span>
                            </label>
                            @php
                                $currentKat = old('kategori', $testimonial->kategori);
                            @endphp
                            <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="Alumni" {{ str_contains(strtolower($currentKat), 'alumni') ? 'selected' : '' }}>Alumni UIS</option>
                                <option value="Mahasiswa" {{ str_contains(strtolower($currentKat), 'mahasiswa') ? 'selected' : '' }}>Mahasiswa Aktif</option>
                                <option value="Mitra Industri" {{ (str_contains(strtolower($currentKat), 'mitra') || str_contains(strtolower($currentKat), 'industri')) ? 'selected' : '' }}>Mitra Dunia Usaha & Industri (DUDI)</option>
                                <option value="Dosen & Staff" {{ (str_contains(strtolower($currentKat), 'dosen') || str_contains(strtolower($currentKat), 'staff')) ? 'selected' : '' }}>Dosen & Tenaga Kependidikan</option>
                                <option value="Pengguna Lulusan / Stakeholder" {{ (str_contains(strtolower($currentKat), 'pengguna') || str_contains(strtolower($currentKat), 'stakeholder')) ? 'selected' : '' }}>Pengguna Lulusan / Stakeholder</option>
                                @if(!empty($currentKat) && !in_array($currentKat, ['Alumni', 'Mahasiswa', 'Mitra Industri', 'Dosen & Staff', 'Pengguna Lulusan / Stakeholder']))
                                    <option value="{{ $currentKat }}" selected>{{ $currentKat }}</option>
                                @endif
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bintang (wajib) --}}
                        <div class="col-md-6">
                            <label for="bintang" class="form-label fw-semibold">
                                Rating Bintang <span class="text-danger">*</span>
                            </label>
                            <select id="bintang" name="bintang" class="form-select @error('bintang') is-invalid @enderror" required>
                                <option value="5" {{ old('bintang', $testimonial->bintang) == 5 ? 'selected' : '' }}>5 Bintang (Sangat Puas)</option>
                                <option value="4" {{ old('bintang', $testimonial->bintang) == 4 ? 'selected' : '' }}>4 Bintang (Puas)</option>
                                <option value="3" {{ old('bintang', $testimonial->bintang) == 3 ? 'selected' : '' }}>3 Bintang (Cukup)</option>
                                <option value="2" {{ old('bintang', $testimonial->bintang) == 2 ? 'selected' : '' }}>2 Bintang (Kurang)</option>
                                <option value="1" {{ old('bintang', $testimonial->bintang) == 1 ? 'selected' : '' }}>1 Bintang (Kecewa)</option>
                            </select>
                            @error('bintang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pesan (wajib) --}}
                    <div class="mb-3">
                        <label for="pesan" class="form-label fw-semibold">
                            Ulasan / Testimoni <span class="text-danger">*</span>
                        </label>
                        <textarea id="pesan"
                                  name="pesan"
                                  class="form-control @error('pesan') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Tuliskan testimoni pengalaman belajar, perkuliahan di Universitas Ibnu Sina, bimbingan dosen, suasana kampus, atau kemudahan berkarir..."
                                  required>{{ old('pesan', $testimonial->pesan) }}</textarea>
                        @error('pesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                   {{ old('aktif', $testimonial->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="aktif">
                                Aktifkan testimoni (tampil di website)
                            </label>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
