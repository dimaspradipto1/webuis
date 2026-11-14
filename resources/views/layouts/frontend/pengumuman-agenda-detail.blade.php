@extends('layouts.frontend.template')

@php
  $isAgenda = $item->tipe === 'agenda';
  $labelTipe = $isAgenda ? 'Agenda Akademik' : 'Pengumuman Resmi';
@endphp

@section('title', $item->judul . ' — ' . $labelTipe . ' Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($item->konten ?: $item->judul), 160))

@section('content')
<style>
  .pa-detail-hero {
    background: #046b26 !important;
    border-bottom: 3px solid #fed802 !important;
    padding: 30px 0 24px;
    color: #fff;
  }
  .pa-main-photo {
    width: 100%;
    max-height: 440px;
    object-fit: cover;
    border-radius: 18px;
  }
  .pa-sidebar-link {
    display: block;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    text-decoration: none;
    color: #1e293b;
    transition: all 0.2s ease;
    margin-bottom: 10px;
  }
  .pa-sidebar-link:hover {
    background: #f0fdf4;
    border-color: #86efac;
    color: #046B26;
    transform: translateY(-1px);
  }
  .pa-agenda-pill {
    display: block;
    padding: 10px 14px;
    border-radius: 10px;
    background: #f4d348;
    color: #1a202c;
    font-weight: 700;
    font-size: 13.5px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .pa-agenda-pill:hover {
    background: #eab308;
    color: #0f172a;
  }
</style>

<!-- Header Hero -->
<div class="pa-detail-hero">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.pengumuman-agenda', ['tipe' => $item->tipe]) }}">{{ $labelTipe }}</a>
      <span>/</span>
      <span class="active">{{ Str::limit($item->judul, 45) }}</span>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
      @if($isAgenda)
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12.5px;">
          <i class="bi bi-calendar4-week me-1"></i>Agenda Akademik
        </span>
      @else
        <span class="badge bg-light text-success px-3 py-2 rounded-pill fw-bold" style="font-size: 12.5px;">
          <i class="bi bi-megaphone-fill me-1"></i>Pengumuman Resmi
        </span>
      @endif

      @if(!empty($item->waktu))
        <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.3); color: #fff; font-size: 12px;">
          <i class="bi bi-clock-fill text-warning me-1"></i>{{ $item->waktu }}
        </span>
      @endif

      @if(!empty($item->lokasi))
        <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.3); color: #fff; font-size: 12px;">
          <i class="bi bi-geo-alt-fill text-warning me-1"></i>{{ $item->lokasi }}
        </span>
      @endif
    </div>

    <h1 class="fw-bold text-white mb-0" style="font-size: clamp(24px, 3.2vw, 35px); line-height: 1.35;">
      {{ $item->judul }}
    </h1>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-2">
    <div class="row g-4 g-lg-5">

      <!-- Kolom Kiri: Foto, Isi Detail, Lampiran -->
      <div class="col-lg-8" data-aos="fade-up">

        @php
          $photos = is_array($item->galeri) ? $item->galeri : [];
          if (!empty($item->foto) && !in_array($item->foto, $photos, true)) {
              array_unshift($photos, $item->foto);
          }
          $mainPhoto = $item->foto ?: ($photos[0] ?? null);
        @endphp

        @if(!empty($mainPhoto))
          <div class="mb-3 position-relative">
            <img id="paMainImg" src="{{ asset('storage/' . $mainPhoto) }}" alt="{{ $item->judul }}" class="pa-main-photo shadow-sm border bg-white">
            <a id="paMainFullLink" href="{{ asset('storage/' . $mainPhoto) }}" target="_blank" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-3 rounded-pill px-3 shadow" style="font-size: 12px; background: rgba(0,0,0,0.65);">
              <i class="bi bi-arrows-fullscreen me-1"></i> Ukuran Penuh
            </a>
          </div>

          @if(count($photos) > 1)
            <div class="d-flex flex-wrap gap-2 mb-4">
              @foreach($photos as $idx => $pImg)
                <button type="button"
                        onclick="document.getElementById('paMainImg').src='{{ asset('storage/' . $pImg) }}'; document.getElementById('paMainFullLink').href='{{ asset('storage/' . $pImg) }}';"
                        class="p-0 border rounded-3 overflow-hidden bg-white shadow-sm"
                        style="width: 84px; height: 60px; cursor: pointer;">
                  <img src="{{ asset('storage/' . $pImg) }}" alt="Foto {{ $idx + 1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                </button>
              @endforeach
            </div>
          @endif
        @endif

        <!-- Card Isi Rincian -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #eaf7ee; color: #046B26; font-size: 19px;">
              <i class="bi {{ $isAgenda ? 'bi-calendar4-event' : 'bi-megaphone-fill' }}"></i>
            </div>
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 21px;">
              Rincian {{ $labelTipe }}
            </h3>
          </div>
          <div class="divider-line mb-4"></div>

          @if(!empty($item->konten))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! $item->konten !!}
            </div>
          @else
            <p style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              Diberitahukan kepada seluruh mahasiswa dan sivitas akademika Universitas Ibnu Sina terkait <strong>{{ $item->judul }}</strong> yang dijadwalkan pada <strong>{{ $item->waktu }}</strong>.
            </p>
          @endif

          <!-- Lampiran Dokumen / Surat Edaran -->
          @if(!empty($item->file_lampiran))
            <div class="mt-4 p-3 px-4 rounded-3 border d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
              <div class="d-flex align-items-center gap-3">
                <i class="bi bi-file-earmark-pdf-fill text-danger fs-2"></i>
                <div>
                  <div class="fw-bold text-dark" style="font-size: 14.5px;">Dokumen / Surat Lampiran Resmi</div>
                  <div class="text-muted small">Unduh dokumen resmi terkait {{ strtolower($labelTipe) }} ini</div>
                </div>
              </div>
              <a href="{{ asset('storage/' . $item->file_lampiran) }}" target="_blank" download class="btn btn-success rounded-pill px-4 fw-semibold btn-sm">
                <i class="bi bi-download me-1"></i> Unduh Lampiran
              </a>
            </div>
          @endif

          <!-- Tautan Eksternal Jika Ada -->
          @if(!empty($item->url))
            <div class="mt-3 p-3 px-4 rounded-3 border d-flex flex-wrap align-items-center justify-content-between gap-3 bg-light">
              <div>
                <div class="fw-bold text-dark" style="font-size: 14px;">Tautan Terkait / Pendaftaran</div>
                <div class="text-muted small text-truncate" style="max-width: 420px;">{{ $item->url }}</div>
              </div>
              <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary rounded-pill px-4 fw-semibold btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tautan
              </a>
            </div>
          @endif

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
            <a href="{{ route('homepage.pengumuman-agenda') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold" style="font-size: 13.5px;">
              <i class="bi bi-arrow-left me-1"></i> Lihat Semua Pengumuman & Agenda
            </a>

            @php
              $shareUrl = urlencode(url()->current());
              $shareText = urlencode($labelTipe . ' UIS: ' . $item->judul);
            @endphp
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small fw-semibold">Bagikan:</span>
              <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="btn btn-sm btn-primary rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-facebook"></i>
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Kolom Kanan: Ringkasan Waktu & Daftar Pengumuman / Agenda Lainnya -->
      <div class="col-lg-4" data-aos="fade-left">

        <!-- Box Informasi Jadwal -->
        <div class="info-badge-card mb-4">
          <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-info-square-fill text-success me-2"></i>Informasi {{ $isAgenda ? 'Agenda' : 'Pengumuman' }}
          </h5>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-tag me-1"></i> Kategori</span>
            <span class="info-meta-val text-success fw-bold">{{ $labelTipe }}</span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-calendar-event me-1"></i> Waktu / Tanggal</span>
            <span class="info-meta-val fw-semibold">{{ $item->waktu ?: '-' }}</span>
          </div>

          @if(!empty($item->lokasi))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-geo-alt me-1"></i> Lokasi / Unit</span>
              <span class="info-meta-val">{{ $item->lokasi }}</span>
            </div>
          @endif
        </div>

        <!-- Pengumuman Lainnya -->
        @if(isset($otherPengumumans) && $otherPengumumans->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
            <h5 class="fw-bold mb-3 text-dark">
              <i class="bi bi-megaphone-fill text-success me-2"></i>Pengumuman Lainnya
            </h5>
            @foreach($otherPengumumans as $op)
              <a href="{{ route('homepage.pengumuman-agenda.detail', $op->slug ?: $op->id) }}" class="pa-sidebar-link">
                <div class="fw-bold mb-1" style="font-size: 13.5px; line-height: 1.4;">{{ $op->judul }}</div>
                <div class="text-muted" style="font-size: 11.5px;"><i class="bi bi-calendar3 me-1"></i>{{ $op->waktu }}</div>
              </a>
            @endforeach
          </div>
        @endif

        <!-- Agenda Lainnya -->
        @if(isset($otherAgendas) && $otherAgendas->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h5 class="fw-bold mb-3 text-dark">
              <i class="bi bi-calendar4-week text-success me-2"></i>Agenda Akademik
            </h5>
            @foreach($otherAgendas as $oa)
              <div class="mb-3">
                <div class="fw-bold text-dark mb-1" style="font-size: 12.5px;">{{ rtrim($oa->waktu, ':') }}:</div>
                <a href="{{ route('homepage.pengumuman-agenda.detail', $oa->slug ?: $oa->id) }}" class="pa-agenda-pill">
                  {{ $oa->judul }}
                </a>
              </div>
            @endforeach
          </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endsection

