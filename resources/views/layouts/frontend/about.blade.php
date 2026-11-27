@extends('layouts.frontend.template')

@section('title', 'Tentang Kami — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Kenali lebih dekat Universitas Ibnu Sina (UIS) — profil, visi misi, nilai karakter akademik, dan fasilitas unggulan kami.')
@section('meta_keywords', 'tentang uis, profil universitas ibnu sina, visi misi uis, struktur organisasi uis, pendidikan kesehatan')

@section('content')
@php
  $cleanWa = '';
  if (!empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<!-- ═══════════════════════════════════════════════
     ABOUT HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'tentang',
    'heroClass' => 'about-hero'
])

<!-- ═══════════════════════════════════════════════
     PROFIL UNIVERSITAS (FULL WIDTH & VIDEO)
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container">
    <div class="row">
      <div class="col-12" data-aos="fade-up" data-aos-duration="800">
        {{-- 1. VIDEO PROFIL DI ATAS (FULL WIDTH) --}}
        @if($about?->hasVideo())
          <div class="w-100 mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border w-100" style="border-color: #e2e8f0; background: #000;">
              @if($about->video_file)
                <video controls class="w-100 d-block" style="max-height: 560px; object-fit: contain;">
                  <source src="{{ asset('storage/' . $about->video_file) }}">
                  Browser Anda tidak mendukung tag video.
                </video>
              @elseif($about->youtube_embed_url)
                <div class="ratio ratio-16x9">
                  <iframe 
                    src="{{ $about->youtube_embed_url }}" 
                    title="Video Profil Universitas Ibnu Sina" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen>
                  </iframe>
                </div>
              @endif
            </div>
            {{-- BAR DI BAWAH VIDEO: LINK YOUTUBE (TEKS RAPI TANPA TOMBOL HIJAU) --}}
            @if($about->youtube_watch_url)
              <div class="d-flex justify-content-end align-items-center gap-1.5 mt-2 px-1 text-muted" style="font-size: 12.5px;">
                <span>Video bermasalah saat diputar?</span>
                <a href="{{ $about->youtube_watch_url }}" target="_blank" rel="noopener noreferrer" class="text-decoration-underline fw-semibold d-inline-flex align-items-center gap-1" style="color: #4b5563 !important;">
                  <i class="bi bi-youtube text-danger"></i> Buka Langsung di YouTube <i class="bi bi-box-arrow-up-right ms-0.5" style="font-size: 10px;"></i>
                </a>
              </div>
            @endif
          </div>
        @endif

        {{-- 2. DESKRIPSI PARAGRAF DI BAWAH (FULL WIDTH 100%) --}}
        <div class="w-100 p-4 p-md-5 rounded-4 shadow-sm mb-4" style="width: 100% !important; max-width: 100% !important; text-align: justify; font-size: 17px; line-height: 2.0; color: #2d3748; background: #f8faf9; border-left: 6px solid var(--uis-green, #046B26); border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;" data-aos="fade-up" data-aos-delay="200">
          <div class="about-desc-content">
            {!! $about->deskripsi_profil_1 ?? 'Universitas Ibnu Sina (UIS) Batam merupakan perguruan tinggi swasta terkemuka di Provinsi Kepulauan Riau yang lahir dari perpaduan keunggulan akademik Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES) di bawah naungan Yayasan Pendidikan Ibnu Sina Batam (YAPISNA). Berlokasi strategis di kawasan industri dan perdagangan internasional Kota Batam, UIS mengelola tiga fakultas unggulan: Fakultas Teknik (Sains & Teknologi), Fakultas Ekonomi dan Bisnis (FEB), serta Fakultas Ilmu Kesehatan (FIKES), beserta Program Pascasarjana (Magister). UIS bertekad mencetak lulusan profesional muda yang inovatif, berdaya saing global, berjiwa entrepreneur, dan berakhlak mulia berlandaskan Iman dan Taqwa (Imtaq).' !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
