<!DOCTYPE html>
<html lang="id">
@php
  if (!isset($cleanWa) || empty($cleanWa)) {
      $cleanWa = '';
      if (!empty($contact->no_wa)) {
          $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
          if (strpos($cleanWa, '08') === 0) {
              $cleanWa = '628' . substr($cleanWa, 2);
          } elseif (strpos($cleanWa, '8') === 0) {
              $cleanWa = '628' . substr($cleanWa, 1);
          }
      }
  }
  $isHome = request()->routeIs('homepage') || request()->routeIs('homepage.galeri');
@endphp
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="referrer" content="strict-origin-when-cross-origin">
  <title>@yield('title', 'Universitas Ibnu Sina (UIS) | Unggul, Profesional & Berintegritas')</title>
  <meta name="description" content="@yield('meta_description', 'Portal Resmi Universitas Ibnu Sina (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.')">
  <meta name="keywords" content="@yield('meta_keywords', 'universitas ibnu sina, uis, pmb uis, pendaftaran uis, kampus batam, perguruan tinggi batam, pendidikan tinggi, riset terpadu')">
  <meta name="author" content="@yield('meta_author', 'Universitas Ibnu Sina')">

  <!-- Open Graph / Facebook / WhatsApp / Telegram Preview -->
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'Universitas Ibnu Sina (UIS) | Unggul, Profesional & Berintegritas'))">
  <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Portal Resmi Universitas Ibnu Sina (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.'))">
  <meta property="og:image" content="@yield('og_image', asset('assets/img/logouis.png'))">
  <meta property="og:image:secure_url" content="@yield('og_image', asset('assets/img/logouis.png'))">
  <meta property="og:image:width" content="@yield('og_image_width', '1200')">
  <meta property="og:image:height" content="@yield('og_image_height', '630')">
  <meta property="og:image:type" content="@yield('og_image_type', 'image/jpeg')">
  <meta property="og:site_name" content="Universitas Ibnu Sina">

  <!-- Twitter / X Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="{{ url()->current() }}">
  <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', 'Universitas Ibnu Sina (UIS) | Unggul, Profesional & Berintegritas'))">
  <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', 'Portal Resmi Universitas Ibnu Sina (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.'))">
  <meta name="twitter:image" content="@yield('og_image', asset('assets/img/logouis.png'))">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logouis.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/logouis.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS Animation CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Swiper Slider CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

  <!-- Master Unified Frontend CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v={{ file_exists(public_path('frontend/css/style.css')) ? filemtime(public_path('frontend/css/style.css')) : time() }}">
  <style>
    figure.image {
      display: table;
      margin: 1.25rem auto;
      max-width: 100%;
      text-align: center;
    }
    figure.image img {
      display: block;
      max-width: 100%;
      height: auto;
      margin: 0 auto;
      border-radius: 8px;
    }
    figure.image figcaption {
      display: table-caption;
      caption-side: bottom;
      padding: 8px 12px 0;
      font-size: 0.875rem;
      color: #64748b;
      font-style: italic;
      text-align: center;
      line-height: 1.5;
    }

    /* ═══════════════════════════════════════════════════════════════
       UIS PREMIUM PAGE TRANSITIONS, MICRO-INTERACTIONS & CTA MOTION
    ═══════════════════════════════════════════════════════════════ */
    #uisScrollProgress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3.5px;
      width: 0%;
      background: linear-gradient(90deg, #046B26 0%, #10b981 50%, #FED802 100%);
      z-index: 99999;
      transition: width 0.12s ease-out;
      box-shadow: 0 0 10px rgba(254, 216, 2, 0.65);
    }

    #uis-realtime-content {
      animation: uisPageReveal 0.65s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    body.uis-page-leaving #uis-realtime-content {
      opacity: 0;
      transform: translateY(10px);
      transition: opacity 0.22s ease, transform 0.22s ease;
    }
    @keyframes uisPageReveal {
      0% {
        opacity: 0;
        transform: translateY(14px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Cinematic Ken Burns Hero Effect */
    #heroCarousel .carousel-item .hero-banner-img {
      transform: scale(1);
      transition: transform 6.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      will-change: transform;
    }
    #heroCarousel .carousel-item.active .hero-banner-img {
      transform: scale(1.055);
    }

    /* Shimmer & Magnetic Lift on CTA Buttons */
    .btn-primary-hero,
    .btn-pmb-wa,
    .btn-uis-pill,
    .uis-join-cta-btn {
      position: relative;
      overflow: hidden;
      transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.32s cubic-bezier(0.22, 1, 0.36, 1) !important;
    }
    .btn-primary-hero::after,
    .btn-pmb-wa::after,
    .btn-uis-pill::after,
    .uis-join-cta-btn::after {
      content: "";
      position: absolute;
      top: 0;
      left: -120%;
      width: 65%;
      height: 100%;
      background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.38), transparent);
      transform: skewX(-22deg);
      animation: uisBtnShimmer 4.2s infinite;
      pointer-events: none;
    }
    .btn-primary-hero:hover,
    .btn-pmb-wa:hover,
    .btn-uis-pill:hover,
    .uis-join-cta-btn:hover {
      transform: translateY(-4px) scale(1.02) !important;
      box-shadow: 0 14px 28px rgba(4, 107, 38, 0.28) !important;
    }
    @keyframes uisBtnShimmer {
      0% { left: -120%; }
      35%, 100% { left: 160%; }
    }

    /* Premium Interactive Card Hover Transitions */
    .value-card,
    .prestasi-card,
    .prestasi-card-portal,
    .fasilitas-card,
    .prodi-card,
    .news-card,
    .gallery-card-item {
      transition: transform 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                  box-shadow 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                  border-color 0.38s ease !important;
      will-change: transform;
    }
    .value-card:hover,
    .prestasi-card:hover,
    .prestasi-card-portal:hover,
    .fasilitas-card:hover,
    .prodi-card:hover,
    .news-card:hover {
      transform: translateY(-8px) !important;
      box-shadow: 0 20px 40px rgba(4, 107, 38, 0.13) !important;
      border-color: rgba(4, 107, 38, 0.35) !important;
    }
    .value-card:hover .value-icon-wrap {
      transform: scale(1.12) rotate(-4deg);
      background: linear-gradient(135deg, #046B26, #069636);
      color: #FED802;
      transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    }

    /* Floating "Gabung UIS" Conversion Widget */
    .uis-floating-join {
      position: fixed;
      bottom: 24px;
      left: 24px;
      z-index: 9990;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .uis-join-trigger {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, #032e12 0%, #046B26 100%);
      color: #ffffff;
      border: 2px solid #FED802;
      border-radius: 999px;
      padding: 10px 18px 10px 12px;
      font-size: 13.5px;
      font-weight: 700;
      box-shadow: 0 12px 28px rgba(3, 46, 18, 0.35);
      cursor: pointer;
      transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
      position: relative;
    }
    .uis-join-trigger:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 16px 34px rgba(4, 107, 38, 0.45);
    }
    .uis-join-badge-dot {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #FED802;
      color: #032e12;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      position: relative;
      flex-shrink: 0;
    }
    .uis-join-badge-dot::before {
      content: "";
      position: absolute;
      inset: -4px;
      border-radius: 50%;
      border: 2px solid #FED802;
      animation: uisPulseRing 2s cubic-bezier(0.22, 1, 0.36, 1) infinite;
    }
    @keyframes uisPulseRing {
      0% { transform: scale(0.95); opacity: 0.9; }
      70% { transform: scale(1.45); opacity: 0; }
      100% { transform: scale(1.45); opacity: 0; }
    }
    .uis-join-card {
      position: absolute;
      bottom: calc(100% + 14px);
      left: 0;
      width: 320px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 22px 48px rgba(15, 23, 42, 0.22);
      border: 1px solid rgba(4, 107, 38, 0.16);
      overflow: hidden;
      opacity: 0;
      visibility: hidden;
      transform: translateY(16px) scale(0.96);
      transform-origin: bottom left;
      transition: all 0.32s cubic-bezier(0.22, 1, 0.36, 1);
      pointer-events: none;
    }
    .uis-floating-join.open .uis-join-card {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
      pointer-events: auto;
    }
    .uis-join-card-header {
      background: linear-gradient(135deg, #032e12 0%, #046B26 100%);
      color: #ffffff;
      padding: 16px 18px;
      position: relative;
    }
    .uis-join-card-body {
      padding: 16px 18px;
    }
    .uis-join-action-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      border-radius: 12px;
      text-decoration: none;
      color: #1e293b;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      margin-bottom: 8px;
      transition: all 0.25s ease;
    }
    .uis-join-action-item:last-child {
      margin-bottom: 0;
    }
    .uis-join-action-item:hover {
      background: #eaf7ee;
      border-color: #046B26;
      color: #046B26;
      transform: translateX(4px);
    }
    .uis-join-action-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    @media (max-width: 576px) {
      .uis-floating-join {
        bottom: 16px;
        left: 14px;
      }
      .uis-join-card {
        width: 290px;
      }
    }
  </style>

  @stack('styles')
</head>

<body>
<div id="uisScrollProgress"></div>

<!-- ═══════════════════════════════════════════════
     NAVBAR HEADER UTAMA
═══════════════════════════════════════════════ -->
@include('layouts.frontend.header')

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<div id="uis-realtime-content">
@yield('content')
</div>

<!-- ═══════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.footer')

<!-- Floating Quick-Join UIS CTA Widget -->
@php
  $pmbDirectLink = $pmbSetting->tombol_link_1 ?? route('homepage.kontak');
  if (!str_starts_with($pmbDirectLink, 'http') && !str_starts_with($pmbDirectLink, '/')) {
      $pmbDirectLink = '/' . $pmbDirectLink;
  }
  $waDirectLink = !empty($cleanWa)
      ? "https://wa.me/{$cleanWa}?text=" . urlencode("Halo Admin PMB Universitas Ibnu Sina, saya tertarik bergabung di UIS dan ingin informasi pendaftaran mahasiswa baru.")
      : route('homepage.kontak');
@endphp
<div class="uis-floating-join" id="uisFloatingJoin">
  <div class="uis-join-card" aria-hidden="true">
    <div class="uis-join-card-header">
      <div class="d-flex align-items-center justify-content-between mb-1">
        <span class="badge rounded-pill px-2 py-1" style="background: #FED802; color: #032e12; font-size: 10.5px; font-weight: 800;">
          <i class="bi bi-stars me-1"></i>PMB UIS DIBUKA
        </span>
        <button type="button" class="btn-close btn-close-white" style="font-size: 10px;" onclick="toggleUisJoinWidget(event)" aria-label="Tutup"></button>
      </div>
      <div class="fw-bold" style="font-size: 15px; line-height: 1.35;">Siap Bergabung di Universitas Ibnu Sina?</div>
      <div class="text-white-50" style="font-size: 11.5px; margin-top: 2px;">Wujudkan karier profesional muda bersama UIS Batam.</div>
    </div>
    <div class="uis-join-card-body">
      <a href="{{ $pmbDirectLink }}" target="{{ str_starts_with($pmbDirectLink, 'http') ? '_blank' : '_self' }}" class="uis-join-action-item">
        <div class="uis-join-action-icon" style="background: #046B26; color: #FED802;">
          <i class="bi bi-rocket-takeoff-fill"></i>
        </div>
        <div>
          <div class="fw-bold" style="font-size: 13px;">Daftar Mahasiswa Baru</div>
          <div class="text-muted" style="font-size: 11px;">Registrasi online cepat & jalur beasiswa</div>
        </div>
        <i class="bi bi-arrow-right ms-auto small"></i>
      </a>

      <a href="{{ route('homepage.program-studi') }}" class="uis-join-action-item">
        <div class="uis-join-action-icon" style="background: #fef3c7; color: #b45309;">
          <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
          <div class="fw-bold" style="font-size: 13px;">Pilih Fakultas & Prodi</div>
          <div class="text-muted" style="font-size: 11px;">Jelajahi program S1 & Pascasarjana S2</div>
        </div>
        <i class="bi bi-arrow-right ms-auto small"></i>
      </a>

      <a href="{{ $waDirectLink }}" target="_blank" rel="noopener" class="uis-join-action-item">
        <div class="uis-join-action-icon" style="background: #dcfce7; color: #15803d;">
          <i class="bi bi-whatsapp"></i>
        </div>
        <div>
          <div class="fw-bold" style="font-size: 13px;">Konsultasi Tim PMB</div>
          <div class="text-muted" style="font-size: 11px;">Tanya biaya kuliah, kelas & pendaftaran</div>
        </div>
        <i class="bi bi-arrow-right ms-auto small"></i>
      </a>
    </div>
  </div>

  <button type="button" class="uis-join-trigger" onclick="toggleUisJoinWidget(event)" aria-label="Bergabung di UIS">
    <span class="uis-join-badge-dot"><i class="bi bi-mortarboard-fill"></i></span>
    <span>Gabung di UIS</span>
    <i class="bi bi-chevron-up small" id="uisJoinChevron" style="transition: transform 0.3s ease;"></i>
  </button>
</div>

<!-- Back to Top -->
<a href="#" class="back-to-top" id="backToTop">
  <i class="bi bi-chevron-up"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Swiper Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  AOS.init({
    once: false,
    mirror: true,
    duration: 720,
    easing: 'ease-out-cubic',
    offset: 35,
    delay: 0
  });

  function toggleUisJoinWidget(e) {
    if (e) e.stopPropagation();
    const wrap = document.getElementById('uisFloatingJoin');
    const chevron = document.getElementById('uisJoinChevron');
    if (!wrap) return;
    wrap.classList.toggle('open');
    if (chevron) {
      chevron.style.transform = wrap.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
  }

  document.addEventListener('click', function(e) {
    const wrap = document.getElementById('uisFloatingJoin');
    const chevron = document.getElementById('uisJoinChevron');
    if (wrap && wrap.classList.contains('open') && !wrap.contains(e.target)) {
      wrap.classList.remove('open');
      if (chevron) chevron.style.transform = 'rotate(0deg)';
    }
  });

  // Top Scroll Progress + BackToTop
  const btn = document.getElementById('backToTop');
  const scrollBar = document.getElementById('uisScrollProgress');
  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    if (btn) btn.classList.toggle('show', scrollTop > 400);
    if (scrollBar) {
      const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const pct = docHeight > 0 ? Math.min(100, (scrollTop / docHeight) * 100) : 0;
      scrollBar.style.width = pct + '%';
    }
  }, { passive: true });

  if (btn) {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Smooth Page Transition on Internal Navigation Links
  document.addEventListener('click', function(e) {
    const link = e.target.closest('a[href]');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    if (link.target === '_blank' || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || link.hasAttribute('download')) return;
    try {
      const targetUrl = new URL(link.href, window.location.origin);
      if (targetUrl.origin === window.location.origin && targetUrl.pathname !== window.location.pathname) {
        document.body.classList.add('uis-page-leaving');
      }
    } catch (err) {}
  });
  window.addEventListener('pageshow', function() {
    document.body.classList.remove('uis-page-leaving');
  });

  function toggleFaq(id) {
    const item = document.getElementById(id);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(f => f.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
</script>

<!-- ═══════════════════════════════════════════════
     GOOGLE TRANSLATE MULTI-LANGUAGE SYSTEM
═══════════════════════════════════════════════ -->
<div id="google_translate_element" style="display:none; position:absolute; left:-9999px; top:-9999px;"></div>

@php
  $includedCodes = (isset($bahasaList) && $bahasaList->count() > 0)
      ? $bahasaList->pluck('kode')->implode(',')
      : 'id,en,ar,zh-CN,nl,tl,fr,de,hi,it,ko,ja';
@endphp

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'id',
      includedLanguages: '{{ $includedCodes }}',
      autoDisplay: false
    }, 'google_translate_element');
  }

  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
    return match ? decodeURIComponent(match[3]) : null;
  }

  function clearGoogTransCookie() {
    var hostname = window.location.hostname;
    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + hostname;
    var domainParts = hostname.split('.');
    while (domainParts.length > 1) {
      document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + domainParts.join('.');
      domainParts.shift();
    }
  }

  function setGoogTransCookie(langCode) {
    var val = '/id/' + langCode;
    var hostname = window.location.hostname;
    document.cookie = "googtrans=" + val + "; path=/;";
    document.cookie = "googtrans=" + val + "; path=/; domain=" + hostname;
    var domainParts = hostname.split('.');
    if (domainParts.length > 1) {
      document.cookie = "googtrans=" + val + "; path=/; domain=." + domainParts.slice(-2).join('.');
    }
  }

  function updateActiveLangUI(langCode, langName, flagUrl) {
    var nameEl = document.getElementById('uisCurrentName');
    var shortEl = document.getElementById('uisCurrentShort');
    var flagImgEl = document.getElementById('uisCurrentFlagImg');

    if (nameEl) nameEl.textContent = langName;
    if (shortEl) {
      var shortName = langName.indexOf(' ') !== -1 ? langName.split(' ')[1] : langName;
      shortEl.textContent = shortName;
    }
    if (flagImgEl && flagUrl) {
      flagImgEl.src = flagUrl;
    }

    document.querySelectorAll('.uis-lang-item').forEach(function(item) {
      item.classList.remove('active-lang');
    });
    document.querySelectorAll('.uis-check-icon').forEach(function(icon) {
      icon.classList.add('d-none');
    });

    var activeItem = document.querySelector('.uis-lang-item[data-code="' + langCode + '"]');
    if (activeItem) {
      activeItem.classList.add('active-lang');
      var checkIcon = document.getElementById('check-lang-' + langCode);
      if (checkIcon) checkIcon.classList.remove('d-none');
    }
  }

  function uisChangeLanguage(langCode, langName, flagUrl) {
    if (langCode === 'id') {
      clearGoogTransCookie();
      localStorage.setItem('uis_selected_lang', 'id');
      localStorage.setItem('uis_selected_lang_name', 'Bahasa Indonesia');
      localStorage.setItem('uis_selected_lang_flag', flagUrl || '{{ asset('assets/img/flags/id.png') }}');
      
      var combo = document.querySelector('.goog-te-combo');
      if (combo) {
        combo.value = 'id';
        combo.dispatchEvent(new Event('change'));
      }
      setTimeout(function() {
        window.location.reload();
      }, 150);
      return;
    }

    setGoogTransCookie(langCode);
    localStorage.setItem('uis_selected_lang', langCode);
    localStorage.setItem('uis_selected_lang_name', langName);
    localStorage.setItem('uis_selected_lang_flag', flagUrl);

    var combo = document.querySelector('.goog-te-combo');
    if (combo) {
      combo.value = langCode;
      combo.dispatchEvent(new Event('change'));
      updateActiveLangUI(langCode, langName, flagUrl);
    } else {
      window.location.reload();
    }
  }

  // Restore active language selection UI on load
  document.addEventListener('DOMContentLoaded', function() {
    var savedCode = localStorage.getItem('uis_selected_lang');
    var savedName = localStorage.getItem('uis_selected_lang_name');
    var savedFlag = localStorage.getItem('uis_selected_lang_flag');

    var googCookie = getCookie('googtrans');
    if (googCookie) {
      var parts = googCookie.split('/');
      var currentCookieLang = parts[parts.length - 1];
      if (currentCookieLang && currentCookieLang !== 'id') {
        savedCode = currentCookieLang;
      } else if (currentCookieLang === 'id') {
        savedCode = 'id';
      }
    }

    if (savedCode) {
      var item = document.querySelector('.uis-lang-item[data-code="' + savedCode + '"]');
      if (item) {
        var flag = item.getAttribute('data-flag') || savedFlag;
        var name = item.getAttribute('data-name') || savedName || savedCode;
        updateActiveLangUI(savedCode, name, flag);
      }
    }
  });
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" defer></script>

@stack('scripts')

<script>
  (function () {
    let currentHash = null;
    let isUpdating = false;
    const stateUrl = '{{ route("homepage.realtime-state") }}';

    async function refreshFrontendContent() {
      if (isUpdating) return;
      isUpdating = true;
      try {
        const res = await fetch(window.location.href, {
          method: 'GET',
          cache: 'no-store',
          headers: {
            'X-Realtime-Sync': '1',
            'Cache-Control': 'no-cache'
          }
        });
        if (!res.ok) return;
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.getElementById('uis-realtime-content');
        const currentContent = document.getElementById('uis-realtime-content');

        if (newContent && currentContent) {
          const scrollY = window.scrollY;
          currentContent.innerHTML = newContent.innerHTML;
          if (doc.title) {
            document.title = doc.title;
          }
          if (typeof AOS !== 'undefined') {
            AOS.refreshHard();
          }
          window.scrollTo({ top: scrollY, behavior: 'instant' });
        }
      } catch (e) {
        // Ignore network errors during background sync
      } finally {
        isUpdating = false;
      }
    }

    async function checkServerVersion() {
      if (document.hidden) return;
      try {
        const res = await fetch(stateUrl + '?_t=' + Date.now(), { cache: 'no-store' });
        if (!res.ok) return;
        const data = await res.json();
        if (data && data.hash) {
          if (currentHash === null) {
            currentHash = data.hash;
          } else if (currentHash !== data.hash) {
            currentHash = data.hash;
            await refreshFrontendContent();
          }
        }
      } catch (e) {}
    }

    // 1. Instant cross-tab sync via BroadcastChannel & localStorage
    if (typeof BroadcastChannel !== 'undefined') {
      try {
        const bc = new BroadcastChannel('uis_realtime_channel');
        bc.onmessage = function (ev) {
          if (ev.data && ev.data.type === 'content_updated') {
            checkServerVersion().then(() => refreshFrontendContent());
          }
        };
      } catch (e) {}
    }

    window.addEventListener('storage', function (ev) {
      if (ev.key === 'uis_realtime_updated_at' && ev.newValue) {
        checkServerVersion().then(() => refreshFrontendContent());
      }
    });

    // 2. Background polling & visibility wakeup for cross-device / cross-browser realtime sync
    checkServerVersion();
    setInterval(checkServerVersion, 4000);
    document.addEventListener('visibilitychange', function () {
      if (!document.hidden) {
        checkServerVersion();
      }
    });
  })();
</script>

</body>
</html>
