@extends('layouts.frontend.template')

@section('title', 'Kampus Berdampak — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Program Kampus Berdampak dan Merdeka Belajar Kampus Merdeka (MBKM) di Universitas Ibnu Sina (UIS) Batam — Mendorong inovasi dan kontribusi nyata bagi masyarakat.')
@section('meta_keywords', 'kampus berdampak, mbkm uis, magang industri, pertukaran mahasiswa, studi independen, kkn tematik, universitas ibnu sina batam')

@push('styles')
<style>
  .kampus-berdampak-hero {
    background: #046b26 !important;
    border-bottom: 3px solid #fed802 !important;
    position: relative;
    overflow: hidden;
    padding-top: 26px !important;
    padding-bottom: 22px !important;
  }
  .kampus-hero-title {
    color: #ffffff !important;
    font-weight: 800 !important;
    font-size: clamp(24px, 3.2vw, 36px) !important;
    letter-spacing: -0.5px;
    margin-bottom: 6px !important;
  }
  .kampus-hero-title em {
    font-style: normal;
    color: #fed802;
  }

  /* Section Styling */
  .kampus-main-section {
    background: #ffffff;
    padding: 60px 0 80px;
  }

  .kampus-column-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(20px, 2.2vw, 26px);
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 26px;
    letter-spacing: -0.3px;
  }

  /* Accordion Program Pilihan */
  .program-accordion {
    border-top: 1px solid #e2e8f0;
  }
  .program-item {
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.2s ease;
  }
  .program-header-btn {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    padding: 18px 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: color 0.2s ease;
  }
  .program-header-btn:hover {
    color: #046B26;
  }
  .program-header-btn .toggle-icon {
    font-size: 20px;
    font-weight: 800;
    color: #046B26;
    line-height: 1;
    display: inline-block;
    width: 18px;
    text-align: center;
    transition: transform 0.2s ease;
  }
  .program-header-btn[aria-expanded="true"] {
    color: #046B26;
  }
  .program-header-btn[aria-expanded="true"] .toggle-icon::before {
    content: "−";
  }
  .program-header-btn[aria-expanded="false"] .toggle-icon::before {
    content: "+";
  }

  .program-body-content {
    padding: 0 12px 22px 30px;
    font-size: 14.5px;
    color: #475569;
    line-height: 1.8;
  }
  .program-body-content p:last-child {
    margin-bottom: 0;
  }

  /* Poster Box Kanan */
  .poster-card-wrap {
    max-width: 440px;
    margin: 0 auto 28px 0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    border: 1px solid #e2e8f0;
    background: #f8fafc;
  }
  .poster-card-img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
  }
  .kampus-desc-text {
    font-size: 14.5px;
    color: #475569;
    line-height: 1.8;
    margin-bottom: 24px;
    text-align: justify;
  }

  /* Download Button */
  .btn-download-mbkm {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #046B26;
    color: #ffffff !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px;
    font-weight: 700;
    padding: 12px 26px;
    border-radius: 8px;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(4, 107, 38, 0.25);
    transition: all 0.25s ease;
    border: none;
  }
  .btn-download-mbkm:hover {
    background-color: #03521d;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(4, 107, 38, 0.35);
  }
</style>
@endpush

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO BANNER & BREADCRUMB STANDAR UIS
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'kampus-berdampak',
    'heroClass' => 'kampus-berdampak-hero'
])

<!-- ═══════════════════════════════════════════════
     MAIN TWO-COLUMN CONTENT
═══════════════════════════════════════════════ -->
<section class="kampus-main-section">
  <div class="container">
    <div class="row g-5">
      <!-- KOLOM KIRI: PROGRAM PILIHAN (ACCORDION) -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-duration="800">
        <h2 class="kampus-column-title">Program Pilihan</h2>

        <div class="program-accordion" id="accordionProgramPilihan">
          @forelse($programs as $index => $program)
            @php
              // Buka default program ke-5 (Project Kemanusiaan) seperti di gambar acuan, atau yang pertama jika hanya sedikit
              $isOpen = ($program->nama_program === 'Project Kemanusiaan') || ($index === 4 && $programs->count() >= 5);
            @endphp
            <div class="program-item">
              <button class="program-header-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProgram{{ $program->id }}" aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="collapseProgram{{ $program->id }}">
                <span class="toggle-icon"></span>
                <span>{{ $program->nama_program }}</span>
              </button>
              <div id="collapseProgram{{ $program->id }}" class="collapse {{ $isOpen ? 'show' : '' }}" data-bs-parent="#accordionProgramPilihan">
                <div class="program-body-content">
                  {!! nl2br(e($program->deskripsi)) !!}
                </div>
              </div>
            </div>
          @empty
            <div class="p-4 bg-light text-center rounded-3 text-muted">
              Belum ada program pilihan yang ditambahkan.
            </div>
          @endforelse
        </div>
      </div>

      <!-- KOLOM KANAN: TENTANG KAMPUS BERDAMPAK & POSTER -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">
        <h2 class="kampus-column-title">{{ $setting->judul_section ?: 'Tentang Kampus Berdampak' }}</h2>

        <!-- Poster Box -->
        <div class="poster-card-wrap">
          @php
            $posterUrl = !empty($setting->poster)
                ? asset('storage/' . $setting->poster)
                : asset('storage/kampus-berdampak/poster-kampus-berdampak.jpg');
          @endphp
          <img src="{{ $posterUrl }}" alt="{{ $setting->judul_section ?: 'Kampus Berdampak' }}" class="poster-card-img" onerror="this.src='{{ asset('storage/kampus-berdampak/poster-kampus-berdampak.jpg') }}'">
        </div>

        <!-- Deskripsi MBKM -->
        <div class="kampus-desc-text">
          {!! nl2br(e($setting->deskripsi ?: 'Merdeka Belajar Kampus Merdeka (MBKM) digaungkan sebagai upaya peningkatan pemahaman mahasiswa yang lebih teknis. Bekerjasama UIS dan Industry, Lembaga Pendidikan lainnya guna menciptakan program-program magang dan praktek kerja, yang membantu lulusan memperoleh pengalaman praktis dan memahami dunia kerja. Dari semua itu, tentu tujuannya untuk meningkatkan kompetensi lulusan, baik soft skills maupun hard skills, agar lebih siap dan relevan dengan kebutuhan zaman.')) !!}
        </div>

        <!-- Tombol Download Panduan MBKM -->
        @php
          $downloadUrl = '#';
          $isExternal = false;
          if (!empty($setting->file_panduan)) {
              $downloadUrl = asset('storage/' . $setting->file_panduan);
          } elseif (!empty($setting->file_panduan_url)) {
              $downloadUrl = $setting->file_panduan_url;
              $isExternal = true;
          }
        @endphp

        <div>
          <a href="{{ $downloadUrl }}" class="btn-download-mbkm" {{ $isExternal ? 'target="_blank" rel="noopener noreferrer"' : 'download' }}>
            <span>{{ $setting->tombol_teks ?: 'Download Panduan MBKM' }}</span>
            <i class="bi bi-chevron-right ms-1" style="font-size: 13px;"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
