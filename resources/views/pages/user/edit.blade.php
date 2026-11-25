@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

{{-- Layout kiri, tidak di-center --}}
<div class="row">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>
                    Edit Pengguna: <span class="text-primary">{{ $user->name }}</span>
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

                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               placeholder="contoh@email.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hak Akses (Multi-Role) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            Hak Akses (Dapat Memilih Lebih dari Satu) <span class="text-danger">*</span>
                        </label>

                        @php
                            $selectedRoles = old('roles') !== null ? (array) old('roles') : $user->roles_array;
                        @endphp

                        <div class="d-flex flex-column gap-2">
                            {{-- Admin --}}
                            <div class="p-2 px-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="admin" id="role_admin" {{ in_array('admin', $selectedRoles) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-primary" for="role_admin">
                                        Admin
                                    </label>
                                </div>
                                <span class="badge bg-primary">Akses Penuh Seluruh Menu</span>
                            </div>

                            {{-- Penulis Berita --}}
                            <div class="p-2 px-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="penulis" id="role_penulis" {{ in_array('penulis', $selectedRoles) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="role_penulis">
                                        Penulis Berita
                                    </label>
                                </div>
                                <span class="badge bg-warning text-dark">Kelola Berita & Pengumuman</span>
                            </div>

                            {{-- Pengelola Organisasi --}}
                            <div class="p-2 px-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="organisasi" id="role_organisasi" {{ in_array('organisasi', $selectedRoles) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="role_organisasi">
                                        Pengelola Organisasi
                                    </label>
                                </div>
                                <span class="badge text-white" style="background:#046B26;">Kelola Organisasi Mahasiswa</span>
                            </div>
                        </div>

                        @error('roles')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Divider Password --}}
                    <hr class="my-3">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Kosongkan field password di bawah jika tidak ingin mengubah password pengguna.
                    </p>

                    {{-- Password Baru (opsional) --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            Password Baru
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePw1">
                                <i class="bi bi-eye" id="eye1"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru (opsional) --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            Konfirmasi Password Baru
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                            <button class="btn btn-outline-secondary" type="button" id="togglePw2">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    function togglePassword(btnId, eyeId, inputId) {
        document.getElementById(btnId).addEventListener('click', function () {
            const inp = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            const show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            eye.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }
    togglePassword('togglePw1', 'eye1', 'password');
    togglePassword('togglePw2', 'eye2', 'password_confirmation');
</script>
@endpush
