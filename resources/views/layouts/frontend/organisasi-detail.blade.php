@extends('layouts.frontend.template')

@section('title', ($organisasi->singkatan ? $organisasi->singkatan . ' — ' : '') . $organisasi->nama_organisasi . ' | Universitas Ibnu Sina')
@section('meta_description', 'Profil lengkap ' . $organisasi->nama_organisasi . ' UIS Universitas Ibnu Sina: Visi, Misi, Susunan Pengurus, Program Kerja dan Kegiatan Kemahasiswaan.')

@section('content')
<!-- HERO SECTION -->
<section class="detail-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="breadcrumb-custom mb-3">
          <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
          <span>/</span>
          <a href="{{ route('homepage.organisasi') }}">Organisasi Mahasiswa</a>
          <span>/</span>
          <span class="active">{{ $organisasi->singkatan ?: $organisasi->nama_organisasi }}</span>
        </div>
        <span class="badge mb-2" style="background:#FED802; color:#1a0528; font-size:12px; font-weight:700; padding:6px 14px;">
          {{ $organisasi->kategori }}
        </span>
        <h1 class="fw-bold text-white mb-2" style="font-size: clamp(24px, 3vw, 36px); line-height: 1.25;">
          {{ $organisasi->nama_organisasi }}
        </h1>
        @if(!empty($organisasi->singkatan))
          <div class="text-white-50 fs-5 mb-0">({{ $organisasi->singkatan }})</div>
        @endif
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0" data-aos="fade-left">
        @if(!empty($organisasi->link_pendaftaran))
          <a href="{{ $organisasi->link_pendaftaran }}" target="_blank" class="btn btn-warning fw-bold px-4 py-2 text-dark shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Daftar Anggota Baru
          </a>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- CONTENT SECTION -->
<section class="py-5" style="background-color: #fbf9fc;">
  <div class="container">
    <div class="row g-4">
      <!-- Main Column -->
      <div class="col-lg-8" data-aos="fade-up">
        <div class="detail-card">
          <!-- Logo & Header info -->
          <div class="d-flex flex-wrap align-items-center gap-4 pb-4 border-bottom mb-4">
            <div class="flex-shrink-0" style="display: flex; align-items: center; justify-content: center;">
              @if(!empty($organisasi->logo))
                <img src="{{ asset('storage/' . $organisasi->logo) }}" alt="{{ $organisasi->nama_organisasi }}" style="width: 85px; height: 85px; object-fit: contain; display: block;">
              @else
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 80px; height: 80px; background: #032e12; font-size: 24px;">
                  {{ strtoupper(substr($organisasi->singkatan ?: $organisasi->nama_organisasi, 0, 2)) }}
                </div>
              @endif
            </div>

            <div>
              <h2 class="h4 fw-bold text-dark mb-1">{{ $organisasi->nama_organisasi }}</h2>
              <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="badge" style="background: var(--uis-purple);">{{ $organisasi->kategori }}</span>
                @if(!empty($organisasi->periode))
                  <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1 text-warning"></i>Periode {{ $organisasi->periode }}</span>
                @endif
              </div>
            </div>
          </div>

          <!-- Banner / Foto Kegiatan (Jika Ada) -->
          @if(!empty($organisasi->foto_kegiatan))
            <div class="mb-4 rounded-4 overflow-hidden shadow-sm">
              <img src="{{ asset('storage/' . $organisasi->foto_kegiatan) }}" alt="Kegiatan {{ $organisasi->nama_organisasi }}" class="w-100" style="max-height: 380px; object-fit: cover;">
            </div>
          @endif

          <!-- Summary Key Info Cards -->
          <div class="row g-3 mb-4">
            <div class="col-sm-6">
              <div class="info-badge-box">
                <div class="info-badge-icon"><i class="bi bi-person-fill"></i></div>
                <div>
                  <small class="text-muted d-block">Ketua Organisasi</small>
                  <strong class="text-dark">{{ $organisasi->nama_ketua ?: 'Belum diisi' }}</strong>
                </div>
              </div>
            </div>

            @if(!empty($organisasi->nama_wakil))
              <div class="col-sm-6">
                <div class="info-badge-box">
                  <div class="info-badge-icon" style="background: #FED802;"><i class="bi bi-person-check"></i></div>
                  <div>
                    <small class="text-muted d-block">Wakil Ketua</small>
                    <strong class="text-dark">{{ $organisasi->nama_wakil }}</strong>
                  </div>
                </div>
              </div>
            @endif



            @if(!empty($organisasi->periode))
              <div class="col-sm-6">
                <div class="info-badge-box">
                  <div class="info-badge-icon" style="background: #FED802; color: #046B26;"><i class="bi bi-calendar-check"></i></div>
                  <div>
                    <small class="text-muted d-block">Masa Bakti</small>
                    <strong class="text-dark">Tahun {{ $organisasi->periode }}</strong>
                  </div>
                </div>
              </div>
            @endif
          </div>

          <!-- Deskripsi & Profil -->
          <div class="mb-4">
            <h3 class="section-subtitle">
              <i class="bi bi-card-text text-primary"></i> Profil Lembaga
            </h3>
            <div class="rich-content">
              {!! $organisasi->deskripsi ?: '<p>Belum ada deskripsi profil untuk organisasi ini.</p>' !!}
            </div>
          </div>

          <!-- Visi & Misi (Jika Ada) -->
          @if(!empty($organisasi->visi) || !empty($organisasi->misi))
            <div class="visi-misi-card">
              @if(!empty($organisasi->visi))
                <div class="mb-3">
                  <h4 class="h6 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-bullseye text-danger"></i> Visi
                  </h4>
                  <div class="mb-0 text-secondary" style="font-size: 14.5px;">{!! $organisasi->visi !!}</div>
                </div>
              @endif

              @if(!empty($organisasi->misi))
                <div>
                  <h4 class="h6 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-list-check text-success"></i> Misi
                  </h4>
                  <div class="text-secondary" style="font-size: 14.5px;">{!! $organisasi->misi !!}</div>
                </div>
              @endif
            </div>
          @endif

          <!-- Back Button -->
          <div class="pt-3 border-top d-flex justify-content-between align-items-center">
            <a href="{{ route('homepage.organisasi') }}" class="btn btn-outline-secondary btn-sm px-3">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Organisasi
            </a>

            @if(!empty($organisasi->link_pendaftaran))
              <a href="{{ $organisasi->link_pendaftaran }}" target="_blank" class="btn btn-success btn-sm px-4 fw-semibold">
                <i class="bi bi-pencil-square me-1"></i> Gabung Sekarang
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Sidebar Column -->
      <div class="col-lg-4" data-aos="fade-left">
        <!-- Contact Card -->
        <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
          <h4 class="h6 fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="bi bi-share-fill me-2 text-primary"></i>Kontak & Media Sosial
          </h4>

          <div class="d-flex flex-column gap-2 mb-3">
            @if(!empty($organisasi->instagram))
              <a href="{{ $organisasi->instagram }}" target="_blank" class="d-flex align-items-center gap-2 p-2 rounded-3 text-decoration-none text-dark bg-light border">
                <i class="bi bi-instagram text-danger fs-5"></i>
                <span class="small fw-semibold">Instagram Resmi</span>
                <i class="bi bi-box-arrow-up-right ms-auto text-muted small"></i>
              </a>
            @endif

            @if(!empty($organisasi->email))
              <a href="mailto:{{ $organisasi->email }}" class="d-flex align-items-center gap-2 p-2 rounded-3 text-decoration-none text-dark bg-light border">
                <i class="bi bi-envelope-fill text-primary fs-5"></i>
                <span class="small fw-semibold">{{ $organisasi->email }}</span>
                <i class="bi bi-send ms-auto text-muted small"></i>
              </a>
            @endif

            @if(!empty($organisasi->link_pendaftaran))
              <a href="{{ $organisasi->link_pendaftaran }}" target="_blank" class="d-flex align-items-center gap-2 p-2 rounded-3 text-decoration-none text-white bg-success">
                <i class="bi bi-pencil-square fs-5"></i>
                <span class="small fw-semibold">Link Formulir Oprec</span>
                <i class="bi bi-box-arrow-up-right ms-auto small"></i>
              </a>
            @endif
          </div>

          <div class="small text-muted p-2 rounded-3 bg-light border">
            <i class="bi bi-geo-alt-fill text-warning me-1"></i>
            Sekretariat Bersama Gedung Universitas Ibnu Sina Batam
          </div>
        </div>

        <!-- Other Organizations -->
        @if($otherOrganisasis->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h4 class="h6 fw-bold text-dark border-bottom pb-2 mb-3">
              <i class="bi bi-people-fill me-2 text-warning"></i>Organisasi Lainnya
            </h4>

            @foreach($otherOrganisasis as $other)
              <a href="{{ route('homepage.organisasi.detail', $other->slug) }}" class="sidebar-ormawa-item">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #faf7fc; border: 1px solid #d4edd9; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  @if(!empty($other->logo))
                    <img src="{{ asset('storage/' . $other->logo) }}" alt="{{ $other->nama_organisasi }}" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 50%;">
                  @else
                    <span class="small fw-bold text-primary">{{ strtoupper(substr($other->singkatan ?: $other->nama_organisasi, 0, 2)) }}</span>
                  @endif
                </div>
                <div class="overflow-hidden">
                  <div class="fw-bold text-dark text-truncate" style="font-size: 13.5px;">{{ $other->nama_organisasi }}</div>
                  <small class="text-muted d-block">{{ $other->kategori }}</small>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
