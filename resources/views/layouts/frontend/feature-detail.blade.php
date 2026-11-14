@extends('layouts.frontend.template')

@section('title', $feature->judul . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', Str::limit(strip_tags($feature->deskripsi), 160))

@push('styles')
<style>
  .feature-detail-hero {
    background: linear-gradient(135deg, #062b16 0%, #0b4f26 55%, #116a34 100%);
    padding: 72px 0 56px;
    color: #fff;
  }
  .feature-detail-icon {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.13);
    font-size: 28px;
  }
  .feature-detail-content {
    max-width: 900px;
    margin: -28px auto 64px;
    position: relative;
    border: 1px solid #e4ede7;
    border-radius: 20px;
    padding: clamp(24px, 5vw, 48px);
    background: #fff;
    box-shadow: 0 12px 32px rgba(8, 46, 22, 0.07);
  }
  .feature-detail-body {
    color: #334155;
    font-size: 16px;
    line-height: 1.9;
    white-space: pre-line;
  }
</style>
@endpush

@section('content')
<section class="feature-detail-hero">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage') }}#keunggulan-beranda">Keunggulan UIS</a>
      <span>/</span>
      <span class="active">{{ Str::limit($feature->judul, 40) }}</span>
    </div>
    <div class="mt-4">
      <div class="feature-detail-icon mb-3"><i class="bi {{ $feature->icon ?: 'bi-layers' }}"></i></div>
      <h1 class="fw-bold mb-3">{{ $feature->judul }}</h1>
      <p class="mb-0 text-white-50 fs-5">{{ $feature->deskripsi }}</p>
    </div>
  </div>
</section>

<main class="container">
  <article class="feature-detail-content">
    <span class="badge rounded-pill px-3 py-2 mb-4" style="background: #eef8f1; color: #0f6830;">
      <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>{{ $feature->badge }}
    </span>
    @if($feature->detail)
      <div class="feature-detail-body">{{ $feature->detail }}</div>
    @else
      <p class="feature-detail-body mb-0">Informasi lebih lengkap mengenai {{ $feature->judul }} akan segera diperbarui.</p>
    @endif
  </article>
</main>
@endsection
