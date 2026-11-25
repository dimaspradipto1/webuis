@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit FAQ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit FAQ
                </h5>
            </div>
            <div class="card-body pt-4">

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

                <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pertanyaan --}}
                    <div class="mb-4">
                        <label for="question" class="form-label fw-semibold">
                            Pertanyaan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="question"
                               name="question"
                               class="form-control @error('question') is-invalid @enderror"
                               value="{{ old('question', $faq->question) }}"
                               placeholder="Masukkan pertanyaan"
                               required>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jawaban --}}
                    <div class="mb-4">
                        <label for="answer" class="form-label fw-semibold">
                            Jawaban <span class="text-danger">*</span>
                        </label>
                        <textarea id="answer"
                                  name="answer"
                                  rows="5"
                                  class="form-control @error('answer') is-invalid @enderror"
                                  placeholder="Masukkan jawaban"
                                  required>{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select id="category"
                                name="category"
                                class="form-select @error('category') is-invalid @enderror"
                                required>
                            <option value="" disabled>Pilih Kategori</option>
                            <option value="pemesanan" {{ old('category', $faq->category) === 'pemesanan' ? 'selected' : '' }}>Pemesanan & Pembayaran</option>
                            <option value="spesifikasi" {{ old('category', $faq->category) === 'spesifikasi' ? 'selected' : '' }}>Spesifikasi & Kustomisasi</option>
                            <option value="pengiriman" {{ old('category', $faq->category) === 'pengiriman' ? 'selected' : '' }}>Pengiriman & Klaim Garansi</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('faq.index') }}" class="btn btn-secondary">
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
