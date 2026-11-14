@extends('layouts.frontend.template')

@section('title', 'Program Studi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Temukan Program Studi (Prodi) pilihan Anda di Universitas Ibnu Sina (UIS) Batam. Program Pascasarjana (S2) dan Program Sarjana (S1) di FEB, FST, dan FIKES.')
@section('meta_keywords', 'program studi uis, prodi universitas ibnu sina, s2 magister manajemen, s2 kesehatan masyarakat, s1 manajemen, s1 akuntansi, s1 teknik industri, s1 teknik informatika, s1 sistem informasi, s1 teknik logistik, s1 teknik perkapalan, s1 k3, s1 kesehatan lingkungan')

@push('styles')
<style>
  .uis-prodi-hero {
    background: linear-gradient(135deg, #062b16 0%, #0b4f26 55%, #116a34 100%);
    padding: 60px 0 45px;
    position: relative;
    overflow: hidden;
    color: #ffffff;
    border-bottom: 3px solid #fed802 !important;
  }
  .uis-prodi-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 85% 20%, rgba(244, 196, 48, 0.16), transparent 45%),
                radial-gradient(circle at 15% 80%, rgba(255, 255, 255, 0.07), transparent 45%);
    pointer-events: none;
  }
  .uis-prodi-intro-section {
    padding: 64px 0 48px;
    background: #ffffff;
    border-bottom: 1px solid #eef2ef;
  }
  .uis-prodi-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #0b5d2a;
    background: #eaf5ee;
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 14px;
  }
  .uis-prodi-cta-box {
    background: linear-gradient(145deg, #07371b 0%, #0d5c2b 100%);
    border-radius: 22px;
    padding: 36px 32px;
    color: #ffffff;
    box-shadow: 0 18px 40px rgba(7, 55, 27, 0.16);
    position: relative;
    overflow: hidden;
  }
  .uis-prodi-cta-box::after {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    right: -40px;
    bottom: -40px;
    border-radius: 50%;
    background: rgba(244, 196, 48, 0.14);
    pointer-events: none;
  }
  .uis-btn-pmb-gold {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #f4c430;
    color: #072914 !important;
    font-weight: 800;
    font-size: 14.5px;
    padding: 13px 26px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 8px 20px rgba(244, 196, 48, 0.3);
  }
  .uis-btn-pmb-gold:hover {
    background: #ffd44d;
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(244, 196, 48, 0.42);
  }

  /* Block Jenjang */
  .uis-jenjang-banner {
    background: linear-gradient(90deg, #07381b 0%, #0e632f 100%);
    color: #ffffff;
    border-radius: 18px;
    padding: 24px 30px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 10px 26px rgba(7, 56, 27, 0.12);
    border-left: 6px solid #f4c430;
  }
  .uis-jenjang-banner h2 {
    font-size: 22px;
    font-weight: 800;
    margin: 0;
    letter-spacing: 0.4px;
    color: #ffffff;
  }
  .uis-jenjang-badge {
    background: rgba(244, 196, 48, 0.2);
    color: #f4c430;
    border: 1px solid rgba(244, 196, 48, 0.45);
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
  }

  /* Pascasarjana Cards */
  .uis-s2-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e3ece6;
    padding: 26px;
    height: 100%;
    transition: all 0.28s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 6px 20px rgba(10, 46, 24, 0.05);
    position: relative;
    overflow: hidden;
  }
  .uis-s2-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #0b5d2a, #f4c430);
  }
  .uis-s2-card:hover {
    transform: translateY(-5px);
    border-color: #0b5d2a;
    box-shadow: 0 16px 34px rgba(11, 93, 42, 0.12);
  }

  /* Fakultas Column Box (Like uis.ac.id/program-studi-uis/) */
  .uis-fakultas-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e1ebe4;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 8px 26px rgba(10, 46, 24, 0.06);
    display: flex;
    flex-direction: column;
  }
  .uis-fakultas-header {
    background: linear-gradient(135deg, #094521 0%, #0e6530 100%);
    color: #ffffff;
    padding: 22px 24px;
    border-bottom: 3px solid #f4c430;
  }
  .uis-fakultas-header h3 {
    font-size: 18px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    line-height: 1.35;
  }
  .uis-fakultas-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .uis-prodi-item-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 15px 18px;
    border-radius: 14px;
    background: #f7faf8;
    border: 1px solid #e6efe9;
    text-decoration: none;
    color: #12281b;
    transition: all 0.22s ease;
  }
  .uis-prodi-item-link:hover {
    background: #eaf5ee;
    border-color: #0b5d2a;
    transform: translateX(4px);
    color: #08441e;
  }
  .uis-prodi-item-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: #ffffff;
    color: #0b5d2a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    box-shadow: 0 3px 10px rgba(11, 93, 42, 0.1);
    flex-shrink: 0;
  }
  .uis-prodi-item-link:hover .uis-prodi-item-icon {
    background: #0b5d2a;
    color: #f4c430;
  }
  .uis-prodi-item-title {
    font-weight: 700;
    font-size: 15px;
    margin-bottom: 2px;
    line-height: 1.3;
  }
  .uis-prodi-item-meta {
    font-size: 12px;
    color: #5b7063;
  }
</style>
@endpush

@section('content')
@php
  $pmbUrl = $pmbSetting->tombol_link_1 ?? 'https://pmb.uis.ac.id';
  if (!str_starts_with($pmbUrl, 'http') && !str_starts_with($pmbUrl, '/')) {
      $pmbUrl = 'https://' . $pmbUrl;
  }
@endphp

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="uis-prodi-hero">
  <div class="container position-relative" style="z-index: 2;">
    <div class="text-center mx-auto" style="max-width: 760px;" data-aos="fade-up" data-aos-duration="700">
      <span class="badge rounded-pill px-3 py-2 mb-3 fw-bold" style="background: rgba(244, 196, 48, 0.18); color: #f4c430; border: 1px solid rgba(244, 196, 48, 0.4); letter-spacing: 1px;">
        <i class="bi bi-mortarboard-fill me-1"></i> AKADEMIK UNIVERSITAS IBNU SINA
      </span>
      <h1 class="fw-extrabold mb-3 text-white" style="font-size: clamp(2rem, 4vw, 3rem);">
        Program Studi <span style="color: #f4c430;">Pilihan Anda</span>
      </h1>
      <div class="breadcrumb-custom justify-content-center">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Program Studi</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     INTRO SECTION (SEPERTI UIS.AC.ID/PROGRAM-STUDI-UIS/)
═══════════════════════════════════════════════ -->
<section class="uis-prodi-intro-section">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="uis-prodi-eyebrow">
          <i class="bi bi-compass-fill"></i> PROGRAM STUDI
        </div>
        <h2 class="fw-extrabold mb-3" style="font-size: clamp(1.75rem, 3vw, 2.35rem); color: #0b2e19;">
          Temukan Prodi Pilihan Anda
        </h2>
        <p class="text-secondary mb-0" style="font-size: 15.5px; line-height: 1.85; text-align: justify;">
          Kami hadir dengan berbagai Program Studi (Prodi) yang dapat Anda pilih. Kenali potensi Anda, kemudian lihat program yang kami tawarkan dan selaraskan keterampilan yang dimiliki untuk dikembangkan lebih lanjut di perguruan tinggi. Komitmen kami terus mengembangkan program studi sesuai kemajuan zaman yang dapat dimanfaatkan bagi kita semua. Selamat bergabung di Universitas Ibnu Sina.
        </p>
      </div>

      <div class="col-lg-5" data-aos="fade-left">
        <div class="uis-prodi-cta-box">
          <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1 rounded-pill">Penerimaan Mahasiswa Baru</span>
          <h3 class="fw-bold text-white mb-2" style="font-size: 24px;">Sudah memiliki pilihan?</h3>
          <p class="text-white-50 small mb-4" style="line-height: 1.65;">
            Daftarkan diri Anda sekarang melalui portal resmi Penerimaan Mahasiswa Baru (PMB) Universitas Ibnu Sina.
          </p>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ $pmbUrl }}" target="_blank" rel="noopener noreferrer" class="uis-btn-pmb-gold">
              <span>Mulai Pendaftaran</span>
              <i class="bi bi-arrow-up-right-circle-fill fs-5"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     DAFTAR PROGRAM STUDI (S2 & S1 PER FAKULTAS)
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #f5f8f6;">
  <div class="container py-2">

    {{-- 1. PROGRAM STUDI PASCASARJANA (S2) --}}
    @if($prodisS2->isNotEmpty())
      <div class="mb-5" data-aos="fade-up">
        <div class="uis-jenjang-banner">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(244,196,48,0.18); color: #f4c430; font-size: 24px;">
              <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div>
              <div class="small text-white-50 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 11px;">Jenjang Strata 2 (Magister)</div>
              <h2>PROGRAM STUDI PASCA SARJANA (S2)</h2>
            </div>
          </div>
          <span class="uis-jenjang-badge">{{ $prodisS2->count() }} Program Studi</span>
        </div>

        <div class="row g-4">
          @foreach($prodisS2 as $prodi)
            <div class="col-md-6">
              <div class="uis-s2-card">
                <div>
                  <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                    <div class="d-flex align-items-center gap-3">
                      <div class="uis-prodi-item-icon" style="width: 52px; height: 52px; font-size: 24px; background: #eaf5ee;">
                        <i class="bi {{ $prodi->icon ?: 'bi-mortarboard-fill' }}"></i>
                      </div>
                      <div>
                        <span class="badge rounded-pill text-bg-success mb-1" style="font-size: 11px;">Program Pascasarjana (S2)</span>
                        <h3 class="fw-bold mb-0" style="font-size: 19px; color: #0c2e19;">
                          <a href="{{ route('homepage.program-studi.detail', $prodi->slug) }}" class="text-decoration-none text-dark stretched-link">
                            {{ $prodi->nama }}
                          </a>
                        </h3>
                      </div>
                    </div>
                    @if($prodi->akreditasi)
                      <span class="badge bg-warning text-dark fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                        <i class="bi bi-patch-check-fill me-1"></i>{{ $prodi->akreditasi }}
                      </span>
                    @endif
                  </div>

                  <p class="text-secondary small mb-3" style="line-height: 1.7;">
                    {{ $prodi->deskripsi_singkat ?: Str::limit(strip_tags($prodi->deskripsi), 150) }}
                  </p>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                  <span class="small fw-semibold text-muted">
                    @if($prodi->gelar)
                      <i class="bi bi-award text-success me-1"></i>Gelar: <strong>{{ $prodi->gelar }}</strong>
                    @else
                      <i class="bi bi-building text-success me-1"></i>{{ $prodi->fakultas }}
                    @endif
                  </span>
                  <span class="fw-bold small" style="color: #0b5d2a;">
                    Lihat Detail Prodi <i class="bi bi-arrow-right ms-1"></i>
                  </span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- 2. PROGRAM STUDI SARJANA (S1) --}}
    @if($prodisS1Grouped->isNotEmpty())
      <div data-aos="fade-up">
        <div class="uis-jenjang-banner">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(244,196,48,0.18); color: #f4c430; font-size: 24px;">
              <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div>
              <div class="small text-white-50 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 11px;">Jenjang Strata 1 (Sarjana)</div>
              <h2>PROGRAM STUDI SARJANA (S1)</h2>
            </div>
          </div>
          <span class="uis-jenjang-badge">{{ $prodis->where('jenjang', '!=', 'S2')->count() }} Program Studi</span>
        </div>

        <div class="row g-4">
          @foreach($prodisS1Grouped as $namaFakultas => $listProdi)
            <div class="col-lg-4 col-md-6">
              <div class="uis-fakultas-card">
                <div class="uis-fakultas-header">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="badge rounded-pill" style="background: rgba(244,196,48,0.2); color: #f4c430; font-size: 11px;">
                      <i class="bi bi-building me-1"></i>Fakultas
                    </span>
                    <span class="small text-white-50 fw-semibold" style="font-size: 12px;">{{ $listProdi->count() }} Prodi</span>
                  </div>
                  <h3>{{ $namaFakultas }}</h3>
                </div>

                <div class="uis-fakultas-body">
                  @foreach($listProdi as $prodi)
                    <a href="{{ route('homepage.program-studi.detail', $prodi->slug) }}" class="uis-prodi-item-link">
                      <div class="d-flex align-items-center gap-3">
                        <div class="uis-prodi-item-icon">
                          <i class="bi {{ $prodi->icon ?: 'bi-mortarboard-fill' }}"></i>
                        </div>
                        <div>
                          <div class="uis-prodi-item-title">{{ $prodi->nama }}</div>
                          <div class="uis-prodi-item-meta">
                            @if($prodi->gelar)
                              <span>Gelar: {{ $prodi->gelar }}</span>
                            @endif
                            @if($prodi->akreditasi)
                              <span class="ms-1">• Akreditasi {{ $prodi->akreditasi }}</span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <i class="bi bi-chevron-right text-success fw-bold"></i>
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</section>
@endsection

