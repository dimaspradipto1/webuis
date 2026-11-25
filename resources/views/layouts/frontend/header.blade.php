<!-- ═══════════════════════════════════════════════
     NAVBAR HEADER UTAMA — UNIVERSITAS IBNU SINA (UIS)
═══════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-xl navbar-main sticky-top">
  <div class="container-fluid px-lg-3 px-xl-3 px-xxl-4">
    <!-- Logo UIS -->
    <a class="navbar-brand navbar-brand-custom me-2 me-xl-3" href="{{ route('homepage') }}">
      <img src="{{ $tampilan->header->logo_url ?? asset('assets/img/logouis.png') }}" alt="Logo {{ $tampilan->header->judul ?? 'Universitas Ibnu Sina' }}" class="brand-logo-img">
      <span class="d-flex flex-column justify-content-center ms-2">
        <span class="brand-title-main">{{ $tampilan->header->judul ?? 'UNIVERSITAS IBNU SINA' }}</span>
        @if(!empty($tampilan->header->subjudul))
          <span class="brand-subtitle">{{ $tampilan->header->subjudul }}</span>
        @endif
      </span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav mx-auto gap-1 align-items-center">
        <!-- Beranda -->
        <li class="nav-item">
          <a href="{{ route('homepage') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage') ? 'active' : '' }}">Beranda</a>
        </li>

        <!-- Profil Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.tentang') || request()->routeIs('homepage.sambutan*') || request()->routeIs('homepage.visi-misi') || request()->routeIs('homepage.struktur-organisasi*') || request()->routeIs('homepage.pimpinan*') || request()->routeIs('homepage.profil-pimpinan*') || request()->routeIs('homepage.sejarah') || request()->routeIs('homepage.fasilitas*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profil <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.tentang') ? 'active' : '' }}" href="{{ route('homepage.tentang') }}"><i class="bi bi-building"></i> Tentang Universitas</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.visi-misi') ? 'active' : '' }}" href="{{ route('homepage.visi-misi') }}"><i class="bi bi-bullseye"></i> Visi & Misi</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.sambutan*') ? 'active' : '' }}" href="{{ route('homepage.sambutan-rektor') }}"><i class="bi bi-person-badge"></i> Sambutan Rektor</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.struktur-organisasi*') || request()->routeIs('homepage.pimpinan*') || request()->routeIs('homepage.profil-pimpinan*') ? 'active' : '' }}" href="{{ route('homepage.struktur-organisasi') }}"><i class="bi bi-diagram-3"></i> Profil dan Struktur Pimpinan</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.sejarah') ? 'active' : '' }}" href="{{ route('homepage.sejarah') }}"><i class="bi bi-hourglass-split"></i> Sejarah Universitas</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.fasilitas*') ? 'active' : '' }}" href="{{ route('homepage.fasilitas') }}"><i class="bi bi-cpu"></i> Fasilitas & Laboratorium</a></li>
          </ul>
        </li>


        <!-- Fakultas (Langsung tanpa Dropdown) -->
        <li class="nav-item">
          <a href="{{ route('homepage.program-studi') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage.layanan*') || request()->routeIs('homepage.program-studi*') || request()->routeIs('homepage.fakultas*') ? 'active' : '' }}">Fakultas</a>
        </li>

        <!-- Kemahasiswaan Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.prestasi*') || request()->routeIs('homepage.organisasi*') || request()->routeIs('homepage.galeri*') || request()->routeIs('homepage.testimoni*') || request()->routeIs('homepage.beasiswa*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kemahasiswaan <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.beasiswa*') ? 'active' : '' }}" href="{{ route('homepage.beasiswa') }}"><i class="bi bi-mortarboard-fill text-success"></i> Program Beasiswa</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.prestasi*') ? 'active' : '' }}" href="{{ route('homepage.prestasi') }}"><i class="bi bi-trophy-fill text-warning"></i> Prestasi Mahasiswa</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.organisasi*') ? 'active' : '' }}" href="{{ route('homepage.organisasi') }}"><i class="bi bi-people-fill text-success"></i> Organisasi & Ormawa</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.galeri*') ? 'active' : '' }}" href="{{ route('homepage.galeri') }}"><i class="bi bi-camera"></i> Galeri Dokumentasi</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.testimoni*') ? 'active' : '' }}" href="{{ route('homepage.testimoni') }}"><i class="bi bi-mortarboard"></i> Alumni & Testimoni</a></li>
          </ul>
        </li>

        <!-- Publikasi Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Publikasi <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            @if(isset($navPublikasis) && $navPublikasis->count() > 0)
              @foreach($navPublikasis as $navPub)
                @php
                  $rawLink = trim($navPub->link ?? '');
                  if (!empty($rawLink) && !str_starts_with($rawLink, 'http://') && !str_starts_with($rawLink, 'https://') && !str_starts_with($rawLink, '/') && !str_starts_with($rawLink, '#')) {
                      $rawLink = 'https://' . $rawLink;
                  }
                  $hasLink = !empty($rawLink);
                  $pubHref = $hasLink ? $rawLink : '#';
                  $isExternal = $hasLink && (str_starts_with($rawLink, 'http://') || str_starts_with($rawLink, 'https://'));
                @endphp
                <li>
                  <a class="dropdown-item dropdown-item-custom"
                     href="{{ $pubHref }}"
                     @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                     title="{{ $navPub->deskripsi ?: $navPub->judul }}">
                    <i class="bi {{ $navPub->icon ?: 'bi-journal-richtext' }}" style="color: var(--uis-green);"></i>
                    <span>{{ $navPub->judul }}</span>
                    @if($isExternal)
                      <i class="bi bi-box-arrow-up-right ms-auto text-muted" style="font-size: 10px;" title="Buka website"></i>
                    @endif
                  </a>
                </li>
              @endforeach
            @else
              <li><a class="dropdown-item dropdown-item-custom" href="https://journal.uis.ac.id/" target="_blank"><i class="bi bi-journal-richtext" style="color: var(--uis-green);"></i> <span>E-Journal UIS</span></a></li>
            @endif
          </ul>
        </li>

        <!-- Informasi Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.news*') || request()->routeIs('homepage.pengumuman-agenda*') || request()->routeIs('homepage.kalender-akademik') || request()->routeIs('homepage.akreditasi') || request()->routeIs('homepage.faq') || request()->routeIs('homepage.kerjasama') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Informasi <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.news.category', 'berita-universitas') }}"><i class="bi bi-newspaper"></i> Berita Kampus</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.pengumuman-agenda*') && request('tipe') === 'pengumuman' ? 'active' : '' }}" href="{{ route('homepage.pengumuman-agenda', ['tipe' => 'pengumuman']) }}"><i class="bi bi-megaphone"></i> Pengumuman</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.pengumuman-agenda*') && request('tipe') === 'agenda' ? 'active' : '' }}" href="{{ route('homepage.pengumuman-agenda', ['tipe' => 'agenda']) }}"><i class="bi bi-calendar-event"></i> Agenda</a></li>
            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.news') }}"><i class="bi bi-card-text"></i> Artikel</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.kalender-akademik') ? 'active' : '' }}" href="{{ route('homepage.kalender-akademik') }}"><i class="bi bi-calendar-check"></i> Kalender Akademik</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.akreditasi') ? 'active' : '' }}" href="{{ route('homepage.akreditasi') }}"><i class="bi bi-patch-check"></i> Akreditasi</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.faq') ? 'active' : '' }}" href="{{ route('homepage.faq') }}"><i class="bi bi-question-circle"></i> FAQ Informasi</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.kerjasama') ? 'active' : '' }}" href="{{ route('homepage.kerjasama') }}"><i class="bi bi-buildings"></i> Mitra Kerjasama</a></li>
          </ul>
        </li>

        <!-- PMB Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.informasi-pmb') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            PMB <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li><a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.informasi-pmb') ? 'active' : '' }}" href="{{ route('homepage.informasi-pmb') }}"><i class="bi bi-info-circle-fill" style="color: #046B26;"></i> Informasi PMB</a></li>
            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.informasi-pmb') }}#brosur-pmb"><i class="bi bi-images"></i> Brosur & Poster PMB</a></li>
            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.informasi-pmb') }}#unduh-panduan"><i class="bi bi-file-earmark-pdf"></i> Dokumen Panduan (PDF)</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            @php
              $pmbPortalUrl = $pmbSetting->tombol_link_1 ?? 'https://pmb.uis.ac.id';
              if (!str_starts_with($pmbPortalUrl, 'http') && !str_starts_with($pmbPortalUrl, '/')) {
                  $pmbPortalUrl = '/' . $pmbPortalUrl;
              }
              $pmbPortalTarget = str_starts_with($pmbPortalUrl, 'http') ? '_blank' : '_self';
            @endphp
            <li>
              <a class="dropdown-item dropdown-item-custom text-success fw-bold d-flex align-items-center justify-content-between" href="{{ $pmbPortalUrl }}" target="{{ $pmbPortalTarget }}">
                <span><i class="bi bi-pencil-square text-success me-1"></i> Daftar Online</span>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
              </a>
            </li>
          </ul>
        </li>

        <!-- Humas -->
        <li class="nav-item">
          <a href="{{ route('homepage.humas') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage.humas*') ? 'active' : '' }}">Humas</a>
        </li>

        <!-- Kontak -->
        <li class="nav-item">
          <a href="{{ route('homepage.kontak') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage.kontak') ? 'active' : '' }}">Kontak</a>
        </li>

        <!-- Pilih Bahasa Dropdown (Di Samping Menu Kontak) -->
        @if(($tampilan->header->lang_visible ?? true) && isset($bahasaList) && $bahasaList->count() > 0)
        <li class="nav-item dropdown uis-lang-nav-item">
          <a class="nav-link nav-link-custom dropdown-toggle uis-lang-toggle" 
             href="#" 
             role="button" 
             data-bs-toggle="dropdown" 
             aria-expanded="false" 
             id="dropdownLangSelect" 
             title="Pilih Bahasa / Select Language">
            <img src="{{ $defaultBahasa?->flag_url ?? asset('assets/img/flags/id.png') }}" 
                 id="uisCurrentFlagImg" 
                 alt="Bendera" 
                 class="uis-flag-img-main" 
                 width="22" 
                 height="15"
                 onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
            <span class="uis-lang-name d-none d-xxl-inline" id="uisCurrentName">{{ $defaultBahasa->nama ?? 'Bahasa Indonesia' }}</span>
            <span class="uis-lang-name d-inline d-xxl-none" id="uisCurrentShort">{{ $defaultBahasa ? (str_contains($defaultBahasa->nama, ' ') ? explode(' ', $defaultBahasa->nama)[1] ?? $defaultBahasa->nama : $defaultBahasa->nama) : 'Indonesia' }}</span>
            <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end uis-lang-menu shadow-lg" aria-labelledby="dropdownLangSelect">
            <li class="px-3 py-1 dropdown-header text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">
              <i class="bi bi-translate me-1"></i> Select Language
            </li>
            @foreach($bahasaList as $lang)
              <li>
                <a class="dropdown-item dropdown-item-custom uis-lang-item justify-content-between" 
                   href="javascript:void(0)" 
                   onclick="uisChangeLanguage('{{ $lang->kode }}', '{{ addslashes($lang->nama) }}', '{{ $lang->flag_url }}')"
                   data-code="{{ $lang->kode }}"
                   data-name="{{ $lang->nama }}"
                   data-flag="{{ $lang->flag_url }}">
                  <span class="d-flex align-items-center gap-2">
                    <img src="{{ $lang->flag_url }}" 
                         alt="{{ $lang->nama }}" 
                         class="uis-flag-img" 
                         width="22" 
                         height="15"
                         onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
                    <span class="uis-lang-text">{{ $lang->nama }}</span>
                  </span>
                  <i class="bi bi-check2 text-success fw-bold uis-check-icon {{ ($lang->is_default) ? '' : 'd-none' }}" id="check-lang-{{ $lang->kode }}"></i>
                </a>
              </li>
            @endforeach
          </ul>
        </li>
        @endif
      </ul>

      <!-- CTA Buttons -->
      <div class="d-flex align-items-center gap-2 mt-3 mt-xl-0">
        <a href="{{ route('login') }}" class="btn-portal-nav" title="Login Portal">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </div>
    </div>
  </div>
</nav>
