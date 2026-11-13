@extends('layouts.frontend.template')

@section('title', 'Mitra & Kerjasama — Universitas Ibnu Sina')
@section('meta_description', 'Jelajahi jejaring mitra Universitas Ibnu Sina dan dokumen kerjasama MOU, MOA, serta IA.')

@section('content')
<style>
  .kerjasama-hero {
    position: relative;
    overflow: hidden;
    padding: 64px 0 74px;
    color: #fff;
    background: linear-gradient(125deg, #073b1b 0%, #0b5626 58%, #138044 100%);
  }
  .kerjasama-hero::before,
  .kerjasama-hero::after {
    position: absolute;
    content: "";
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: 50%;
    pointer-events: none;
  }
  .kerjasama-hero::before {
    width: 430px;
    height: 430px;
    top: -245px;
    right: -80px;
    box-shadow: 0 0 0 40px rgba(255, 255, 255, .025), 0 0 0 90px rgba(255, 255, 255, .02);
  }
  .kerjasama-hero::after {
    width: 270px;
    height: 270px;
    bottom: -205px;
    left: 8%;
  }
  .kerjasama-hero .container {
    position: relative;
    z-index: 1;
  }
  .kerjasama-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border: 1px solid rgba(255, 255, 255, .25);
    border-radius: 999px;
    color: #ffdf4d;
    background: rgba(255, 255, 255, .08);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
  }
  .kerjasama-hero h1 {
    max-width: 760px;
    margin: 20px 0 14px;
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 800;
    letter-spacing: -.045em;
    line-height: 1.12;
  }
  .kerjasama-hero p {
    max-width: 690px;
    margin: 0;
    color: rgba(255, 255, 255, .78);
    font-size: 1.05rem;
    line-height: 1.8;
  }
  .kerjasama-stats {
    position: relative;
    z-index: 2;
    margin-top: -30px;
  }
  .kerjasama-stat-card,
  .mitra-card,
  .agreement-card {
    height: 100%;
    border: 1px solid #e3ebe5;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 12px 32px rgba(12, 47, 25, .06);
  }
  .kerjasama-stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
  }
  .kerjasama-stat-icon {
    display: inline-flex;
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: #0b5b2a;
    background: #edf7f0;
    font-size: 21px;
  }
  .kerjasama-stat-value {
    color: #12351f;
    font-size: 24px;
    font-weight: 800;
    line-height: 1.1;
  }
  .kerjasama-stat-label {
    margin-top: 5px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
  }
  .kerjasama-section {
    padding: 72px 0;
  }
  .kerjasama-section-heading {
    max-width: 730px;
    margin: 0 auto 34px;
    text-align: center;
  }
  .kerjasama-section-heading h2 {
    margin: 12px 0;
    color: #10251a;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.8rem, 3vw, 2.45rem);
    font-weight: 800;
    letter-spacing: -.035em;
  }
  .kerjasama-section-heading p {
    margin: 0;
    color: #64748b;
    line-height: 1.8;
  }
  .mitra-card {
    display: flex;
    flex-direction: column;
    padding: 22px;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
  }
  .mitra-card:hover {
    transform: translateY(-4px);
    border-color: #b7ddc2;
    box-shadow: 0 18px 38px rgba(12, 47, 25, .1);
  }
  .mitra-logo-wrap {
    display: flex;
    min-height: 116px;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    padding: 16px;
    border-radius: 14px;
    background: #f7faf8;
  }
  .mitra-logo-wrap img {
    max-width: 100%;
    max-height: 82px;
    object-fit: contain;
  }
  .mitra-logo-placeholder {
    color: #0b5b2a;
    font-size: 32px;
  }
  .mitra-card h3 {
    margin: 0;
    color: #14251b;
    font-size: 16px;
    font-weight: 800;
    line-height: 1.45;
  }
  .mitra-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: 14px;
    padding-top: 13px;
    border-top: 1px solid #edf1ee;
    color: #64748b;
    font-size: 12px;
  }
  .agreement-section {
    background: #f5f8f6;
  }
  .agreement-tabs {
    justify-content: center;
    gap: 10px;
    margin-bottom: 28px;
  }
  .agreement-tabs .nav-link {
    min-width: 105px;
    padding: 11px 22px;
    border: 1px solid #dce8df;
    border-radius: 999px;
    color: #31523b;
    background: #fff;
    font-weight: 800;
  }
  .agreement-tabs .nav-link.active {
    border-color: #0b5b2a;
    color: #fff;
    background: #0b5b2a;
    box-shadow: 0 8px 18px rgba(11, 91, 42, .18);
  }
  .agreement-card {
    padding: 24px;
  }
  .agreement-type {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 999px;
    color: #0b5b2a;
    background: #eaf6ee;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .06em;
  }
  .agreement-card h3 {
    margin: 15px 0 8px;
    color: #17291d;
    font-size: 18px;
    font-weight: 800;
  }
  .agreement-partner {
    color: #0b5b2a;
    font-size: 13px;
    font-weight: 700;
  }
  .agreement-description {
    margin: 14px 0 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.75;
  }
  .agreement-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 18px;
    margin-top: 17px;
    color: #64748b;
    font-size: 12px;
  }
  .agreement-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    margin-top: 20px;
  }
  .agreement-empty {
    padding: 48px 24px;
    border: 1px dashed #cbd9ce;
    border-radius: 20px;
    color: #64748b;
    background: rgba(255, 255, 255, .7);
    text-align: center;
  }
  @media (max-width: 575.98px) {
    .kerjasama-hero {
      padding: 48px 0 60px;
    }
    .kerjasama-section {
      padding: 54px 0;
    }
    .kerjasama-stat-card {
      padding: 15px;
    }
    .agreement-tabs {
      gap: 6px;
    }
    .agreement-tabs .nav-link {
      min-width: 0;
      padding: 9px 16px;
    }
  }
</style>

<section class="kerjasama-hero">
  <div class="container">
    <nav class="small mb-4" aria-label="Breadcrumb">
      <a href="{{ route('homepage') }}" class="text-white-50 text-decoration-none">Beranda</a>
      <span class="mx-2 text-white-50">/</span>
      <span class="text-white">Mitra & Kerjasama</span>
    </nav>
    <span class="kerjasama-eyebrow"><i class="bi bi-diagram-3"></i> Jejaring Kolaborasi UIS</span>
    <h1>Mitra Strategis, Kolaborasi Berdampak</h1>
    <p>
      Universitas Ibnu Sina membangun kemitraan yang saling menguatkan dengan dunia usaha,
      pemerintah, dan institusi pendidikan melalui program kolaborasi yang terukur dan berkelanjutan.
    </p>
  </div>
</section>

<section class="kerjasama-stats">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="kerjasama-stat-card">
          <span class="kerjasama-stat-icon"><i class="bi bi-buildings"></i></span>
          <div>
            <div class="kerjasama-stat-value">{{ $partners->count() }}</div>
            <div class="kerjasama-stat-label">Mitra aktif</div>
          </div>
        </div>
      </div>
      @foreach($agreementTypes as $type)
        <div class="col-6 col-lg-3">
          <div class="kerjasama-stat-card">
            <span class="kerjasama-stat-icon"><i class="bi bi-file-earmark-check"></i></span>
            <div>
              <div class="kerjasama-stat-value">{{ $agreementCounts->get($type, 0) }}</div>
              <div class="kerjasama-stat-label">Dokumen {{ $type }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="kerjasama-section">
  <div class="container">
    <div class="kerjasama-section-heading">
      <span class="kerjasama-eyebrow" style="color:#0b5b2a;background:#edf7f0;border-color:#d6eadb;">
        <i class="bi bi-buildings"></i> Rekan Kolaborasi
      </span>
      <h2>Bergerak Bersama Para Mitra</h2>
      <p>Jejaring mitra yang mendukung pengembangan pendidikan, riset, dan pengalaman profesional mahasiswa.</p>
    </div>

    @if($partners->isNotEmpty())
      <div class="row g-3 g-lg-4">
        @foreach($partners as $partner)
          <div class="col-6 col-md-4 col-xl-3">
            <article class="mitra-card">
              <div class="mitra-logo-wrap">
                @if($partner->logo)
                  <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo {{ $partner->nama }}" loading="lazy">
                @else
                  <i class="bi bi-building mitra-logo-placeholder" aria-hidden="true"></i>
                @endif
              </div>
              <h3>{{ $partner->nama }}</h3>
              <div class="mitra-card-meta">
                <span><i class="bi bi-file-earmark-text me-1"></i>{{ $partner->agreements_count }} dokumen</span>
                <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    @else
      <div class="agreement-empty">
        <i class="bi bi-buildings fs-2 d-block mb-2"></i>
        Data mitra akan ditampilkan di sini setelah ditambahkan oleh administrator.
      </div>
    @endif
  </div>
</section>

<section class="kerjasama-section agreement-section" id="dokumen-kerjasama">
  <div class="container">
    <div class="kerjasama-section-heading">
      <span class="kerjasama-eyebrow" style="color:#0b5b2a;background:#edf7f0;border-color:#d6eadb;">
        <i class="bi bi-file-earmark-check"></i> Dokumen Resmi
      </span>
      <h2>Program Kerjasama</h2>
      <p>Jelajahi dokumen kolaborasi berdasarkan jenis perjanjian yang dijalankan bersama mitra.</p>
    </div>

    <ul class="nav agreement-tabs" id="agreementTabs" role="tablist">
      @foreach($agreementTypes as $type)
        <li class="nav-item" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                  id="tab-{{ strtolower($type) }}"
                  data-bs-toggle="tab"
                  data-bs-target="#panel-{{ strtolower($type) }}"
                  type="button"
                  role="tab"
                  aria-controls="panel-{{ strtolower($type) }}"
                  aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ $type }}
            <span class="badge rounded-pill ms-1 {{ $loop->first ? 'text-bg-light' : 'text-bg-success' }}">
              {{ $agreementCounts->get($type, 0) }}
            </span>
          </button>
        </li>
      @endforeach
    </ul>

    <div class="tab-content">
      @foreach($agreementTypes as $type)
        @php $typeAgreements = $agreementsByType->get($type, collect()); @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
             id="panel-{{ strtolower($type) }}"
             role="tabpanel"
             aria-labelledby="tab-{{ strtolower($type) }}"
             tabindex="0">
          @if($typeAgreements->isNotEmpty())
            <div class="row g-3">
              @foreach($typeAgreements as $agreement)
                <div class="col-lg-6">
                  <article class="agreement-card">
                    <span class="agreement-type"><i class="bi bi-patch-check-fill"></i>{{ $agreement->jenis }}</span>
                    <h3>{{ $agreement->judul }}</h3>
                    <div class="agreement-partner">
                      <i class="bi bi-building me-1"></i>{{ $agreement->partner->nama }}
                    </div>
                    @if($agreement->deskripsi)
                      <p class="agreement-description">{{ $agreement->deskripsi }}</p>
                    @endif
                    <div class="agreement-meta">
                      @if($agreement->nomor)
                        <span><i class="bi bi-hash me-1"></i>{{ $agreement->nomor }}</span>
                      @endif
                      @if($agreement->tanggal_mulai)
                        <span><i class="bi bi-calendar3 me-1"></i>
                          {{ $agreement->tanggal_mulai->translatedFormat('d M Y') }}
                          @if($agreement->tanggal_selesai)
                            – {{ $agreement->tanggal_selesai->translatedFormat('d M Y') }}
                          @endif
                        </span>
                      @endif
                    </div>
                    @if($agreement->file_path || $agreement->tautan)
                      <div class="agreement-actions">
                        @if($agreement->file_path)
                          <a href="{{ asset('storage/' . $agreement->file_path) }}"
                             target="_blank"
                             rel="noopener noreferrer"
                             class="btn btn-success btn-sm rounded-pill px-3">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Lihat dokumen
                          </a>
                        @endif
                        @if($agreement->tautan)
                          <a href="{{ $agreement->tautan }}"
                             target="_blank"
                             rel="noopener noreferrer"
                             class="btn btn-outline-success btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Buka tautan
                          </a>
                        @endif
                      </div>
                    @endif
                  </article>
                </div>
              @endforeach
            </div>
          @else
            <div class="agreement-empty">
              <i class="bi bi-folder2-open fs-2 d-block mb-2"></i>
              Belum ada dokumen {{ $type }} yang dipublikasikan.
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="py-4 bg-white">
  <div class="container text-center">
    <a href="{{ route('homepage') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
    </a>
  </div>
</section>
@endsection
