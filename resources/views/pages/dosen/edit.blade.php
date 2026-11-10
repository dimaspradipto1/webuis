@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Dosen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Dosen</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Dosen: {{ $dosen->nama_dosen }}
        </h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('dosen.update', $dosen->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                {{-- Nama Dosen & Gelar (Fullwidth) --}}
                <div class="col-12">
                    <label for="nama_dosen" class="form-label fw-semibold text-dark">Nama Lengkap & Gelar Dosen <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dosen" id="nama_dosen" class="form-control @error('nama_dosen') is-invalid @enderror" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
                    @error('nama_dosen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Program Studi --}}
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label fw-semibold text-dark">Program Studi <span class="text-danger">*</span></label>
                    <select name="layanan_id" id="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('layanan_id', $dosen->layanan_id) == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->judul }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jabatan Fungsional --}}
                <div class="col-md-6">
                    <label for="jabatan_fungsional" class="form-label fw-semibold text-dark">Jabatan Fungsional</label>
                    <select name="jabatan_fungsional" id="jabatan_fungsional" class="form-select @error('jabatan_fungsional') is-invalid @enderror">
                        <option value="">-- Pilih Jabatan Fungsional --</option>
                        <option value="Tenaga Pengajar" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == 'Tenaga Pengajar' ? 'selected' : '' }}>Tenaga Pengajar</option>
                        <option value="Asisten Ahli" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                        <option value="Lektor" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                        <option value="Lektor Kepala" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                        <option value="Guru Besar" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == 'Guru Besar' ? 'selected' : '' }}>Guru Besar / Profesor</option>
                    </select>
                    @error('jabatan_fungsional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NIDN --}}
                <div class="col-md-6">
                    <label for="nidn" class="form-label fw-semibold text-dark">NIDN (Nomor Induk Dosen Nasional)</label>
                    <input type="text" name="nidn" id="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn', $dosen->nidn) }}">
                    @error('nidn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NUPTK --}}
                <div class="col-md-6">
                    <label for="nuptk" class="form-label fw-semibold text-dark">NUPTK (Nomor Unik Pendidik)</label>
                    <input type="text" name="nuptk" id="nuptk" class="form-control @error('nuptk') is-invalid @enderror" value="{{ old('nuptk', $dosen->nuptk) }}">
                    @error('nuptk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Link Profil Online (Opsional) --}}
                <div class="col-md-7">
                    <label for="link" class="form-label fw-semibold text-dark">
                        Link / Tautan Profil Online <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" placeholder="https://pddikti.kemdiktisaintek.go.id/..." value="{{ old('link', $dosen->link) }}">
                    <small class="text-muted">Masukkan link PDDIKTI, SINTA, Google Scholar, atau CV Online dosen</small>
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto Dosen (Opsional) --}}
                <div class="col-md-5">
                    <label for="foto" class="form-label fw-semibold text-dark">Foto Profil Dosen <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    @if(!empty($dosen->foto))
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('storage/' . $dosen->foto) }}" alt="{{ $dosen->nama_dosen }}" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="small text-muted">Foto profil saat ini</span>
                        </div>
                    @endif
                    <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, WEBP (Maks. 20 MB).</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="col-12">
                    <div class="form-check form-switch p-2 bg-light rounded-3 border d-flex align-items-center gap-3 mt-2">
                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $dosen->is_active) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                            Tampilkan dosen ini pada direktori dosen publik
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Perbarui Data Dosen
                </button>
                <a href="{{ route('dosen.index') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
