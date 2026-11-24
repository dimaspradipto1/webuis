@extends('layouts.frontend.template')

@section('title', 'Organisasi & Kegiatan Mahasiswa — Universitas Ibnu Sina')
@section('meta_description', 'Daftar Lembaga, Organisasi Mahasiswa (BEM, HIMA, UKM, Komunitas), serta wadah kreativitas dan kegiatan mahasiswa UIS Universitas Ibnu Sina.')

@section('content')
<!-- HERO SECTION -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'organisasi-mahasiswa',
    'heroClass' => 'ormawa-hero'
])

<!-- MAIN CONTENT SECTION -->
<section class="py-5" style="background-color: #fbf9fc; min-height: 500px;">
  <div class="container">
    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-3 p-md-4 rounded-4 shadow-sm border mb-4" data-aos="fade-up">
      <div class="row g-3 align-items-center justify-content-between">
        <!-- Category Filter Pills -->
        <div class="col-lg-8">
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('homepage.organisasi', array_filter(['q' => $search])) }}"
               class="category-pill {{ empty($selectedKategori) ? 'active' : '' }}">
              <i class="bi bi-grid-fill me-1"></i> Semua Lembaga
            </a>
            @foreach($kategoriList as $kat)
              <a href="{{ route('homepage.organisasi', array_filter(['kategori' => $kat, 'q' => $search])) }}"
                 class="category-pill {{ $selectedKategori == $kat ? 'active' : '' }}">
                {{ $kat }}
              </a>
            @endforeach
          </div>
        </div>

        <!-- Search Input -->
        <div class="col-lg-4">
          <form action="{{ route('homepage.organisasi') }}" method="GET">
            @if(!empty($selectedKategori))
              <input type="hidden" name="kategori" value="{{ $selectedKategori }}">
            @endif
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Cari nama organisasi, ketua..." value="{{ $search }}" style="border-radius: 50px 0 0 50px; border-color: #e0d0e8; padding-left: 18px; font-size: 13.5px;">
              <button class="btn btn-primary px-4" type="submit" style="background: var(--uis-purple); border-color: var(--uis-purple); border-radius: 0 50px 50px 0;">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Active Search Filter Alert -->
    @if(!empty($search) || !empty($selectedKategori))
      <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded-3 border mb-4">
        <div class="small">
          Menampilkan hasil untuk:
          @if(!empty($selectedKategori))
            <span class="badge bg-success me-1">{{ $selectedKategori }}</span>
          @endif
          @if(!empty($search))
            <span class="badge bg-warning text-dark">Kata kunci: "{{ $search }}"</span>
          @endif
        </div>
        <a href="{{ route('homepage.organisasi') }}" class="btn btn-sm btn-outline-danger" style="font-size: 12px;">
          <i class="bi bi-x-circle me-1"></i> Reset Filter
        </a>
      </div>
    @endif

    <!-- Organisasi Cards Grid -->
    @if($organisasiList->count() > 0)
      <div class="row g-4">
        @foreach($organisasiList as $item)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 80 }}">
            <div class="ormawa-card">
              <!-- Card Top Header with Half-Card Image -->
              <div class="ormawa-card-header">
                @if(!empty($item->foto_kegiatan))
                  <img src="{{ asset('storage/' . $item->foto_kegiatan) }}" alt="{{ $item->nama_organisasi }}" class="ormawa-img-top">
                @elseif(!empty($item->logo))
                  <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->nama_organisasi }}" class="ormawa-img-top">
                @else
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold" style="background: #032e12; font-size: 28px;">
                    {{ strtoupper(substr($item->singkatan ?: $item->nama_organisasi, 0, 2)) }}
                  </div>
                @endif
                <div style="position: absolute; top: 12px; left: 12px;">
                  <span class="ormawa-badge-cat" style="backdrop-filter: blur(4px);">{{ $item->kategori }}</span>
                </div>
              </div>

              <!-- Card Body -->
              <div class="ormawa-card-body">
                <h2 class="ormawa-title">
                  <a href="{{ route('homepage.organisasi.detail', $item->slug) }}">
                    {{ $item->nama_organisasi }}
                  </a>
                </h2>

                <div class="ormawa-leader-box">
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted"><i class="bi bi-person-fill text-primary me-1"></i>Ketua:</span>
                    <strong class="text-dark">{{ $item->nama_ketua ?: 'Belum diisi' }}</strong>
                  </div>
                  @if(!empty($item->periode))
                    <div class="d-flex justify-content-between">
                      <span class="text-muted"><i class="bi bi-calendar3 text-warning me-1"></i>Periode:</span>
                      <span class="text-secondary fw-semibold">{{ $item->periode }}</span>
                    </div>
                  @endif
                </div>

                <div class="ormawa-desc">
                  {{ strip_tags($item->deskripsi ?: ($item->visi ?: 'Lembaga kemahasiswaan Universitas Ibnu Sina.')) }}
                </div>
              </div>

              <!-- Card Footer -->
              <div class="ormawa-card-footer">
                <!-- Social links -->
                <div class="d-flex align-items-center gap-2">
                  @if(!empty($item->instagram))
                    <a href="{{ $item->instagram }}" target="_blank" class="badge bg-light text-danger border p-2" title="Instagram Resmi">
                      <i class="bi bi-instagram" style="font-size: 13px;"></i>
                    </a>
                  @endif
                  @if(!empty($item->email))
                    <a href="mailto:{{ $item->email }}" class="badge bg-light text-primary border p-2" title="Email Resmi">
                      <i class="bi bi-envelope" style="font-size: 13px;"></i>
                    </a>
                  @endif
                  @if(!empty($item->link_pendaftaran))
                    <a href="{{ $item->link_pendaftaran }}" target="_blank" class="badge bg-success text-white border p-2" title="Pendaftaran / Oprec">
                      <i class="bi bi-pencil-square" style="font-size: 13px;"></i>
                    </a>
                  @endif
                </div>

                <a href="{{ route('homepage.organisasi.detail', $item->slug) }}" class="btn-ormawa-detail">
                  <span>Profil & Kegiatan</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-5">
        {{ $organisasiList->links('pagination::bootstrap-5') }}
      </div>
    @else
      <div class="text-center py-5 bg-white rounded-4 border shadow-sm my-4">
        <i class="bi bi-people text-muted" style="font-size: 50px;"></i>
        <h5 class="fw-bold mt-3 text-dark">Data Organisasi Tidak Ditemukan</h5>
        <p class="text-muted mb-3">Silakan gunakan kata kunci lain atau pilih kategori yang tersedia.</p>
        <a href="{{ route('homepage.organisasi') }}" class="btn btn-primary btn-sm px-4" style="background: var(--uis-purple); border-color: var(--uis-purple);">
          Lihat Semua Organisasi
        </a>
      </div>
    @endif
  </div>
</section>
@endsection
