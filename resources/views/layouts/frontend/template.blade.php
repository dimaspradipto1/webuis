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
       UIS ARCHITECTURE — SUBTLE INTERFACE & NAVIGATION TRANSITIONS
    ═══════════════════════════════════════════════════════════════ */
    #uis-realtime-content {
      animation: uisPageReveal 0.35s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    body.uis-page-leaving #uis-realtime-content {
      opacity: 0;
      transition: opacity 0.16s ease;
    }
    @keyframes uisPageReveal {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    .value-card,
    .prestasi-card,
    .prestasi-card-portal,
    .fasilitas-card,
    .prodi-card,
    .news-card,
    .gallery-card-item {
      transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1),
                  box-shadow 0.28s cubic-bezier(0.22, 1, 0.36, 1),
                  border-color 0.28s ease !important;
    }
    .value-card:hover,
    .prestasi-card:hover,
    .prestasi-card-portal:hover,
    .fasilitas-card:hover,
    .prodi-card:hover,
    .news-card:hover {
      transform: translateY(-4px) !important;
      box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08) !important;
      border-color: rgba(4, 107, 38, 0.28) !important;
    }

    /* Floating WhatsApp Admin Button (Bottom-Right) */
    .uis-wa-float-btn {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 1000;
      display: inline-flex;
      align-items: center;
      gap: 9px;
      height: 44px;
      padding: 0 16px 0 10px;
      border-radius: 12px;
      background: #046B26;
      color: #ffffff !important;
      border: 1px solid #FED802;
      box-shadow: 0 8px 22px rgba(4, 107, 38, 0.28);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13px;
      font-weight: 700;
      text-decoration: none;
      transition: transform 0.25s ease, background-color 0.25s ease, box-shadow 0.25s ease;
    }
    .uis-wa-float-btn:hover {
      background: #03521d;
      color: #FED802 !important;
      transform: translateY(-3px);
      box-shadow: 0 12px 26px rgba(4, 107, 38, 0.36);
    }
    .uis-wa-float-icon {
      width: 26px;
      height: 26px;
      border-radius: 8px;
      background: #25D366;
      color: #ffffff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      flex-shrink: 0;
    }
    @media (max-width: 576px) {
      .uis-wa-float-btn {
        bottom: 18px;
        right: 18px;
        padding: 0 13px 0 9px;
        font-size: 12.5px;
      }
      .back-to-top {
        bottom: 72px !important;
        right: 18px !important;
      }
    }

    /* Dropdown Item Active State — Matches UIS Hover Theme */
    .dropdown-item-custom:hover,
    .dropdown-item-custom.active,
    .dropdown-item-custom:active {
      background-color: var(--uis-green-light, #eaf6ee) !important;
      color: var(--uis-green, #046b26) !important;
      font-weight: 700 !important;
    }
    .dropdown-item-custom:hover i,
    .dropdown-item-custom.active i,
    .dropdown-item-custom:active i {
      color: var(--uis-green, #046b26) !important;
    }

    /* ═══════════════════════════════════════════════════════════════
       RESPONSIVE OPTIMIZATION FOR 14-INCH LAPTOPS (1200px - 1440px)
       & COMMON 768p VIEWPORTS (1366x768 / 1280x720 / 150% SCALING)
    ═══════════════════════════════════════════════════════════════ */
    @media (min-width: 1200px) and (max-width: 1440px) {
      .navbar-main {
        min-height: 68px !important;
        padding: 8px 0 !important;
      }
      .navbar-main .container-fluid {
        padding-left: 12px !important;
        padding-right: 12px !important;
      }
      .navbar-brand-custom {
        margin-right: 6px !important;
      }
      .brand-logo-img {
        height: 40px !important;
        max-height: 40px !important;
      }
      .brand-title-main {
        font-size: 13px !important;
        letter-spacing: 0.2px !important;
      }
      .brand-subtitle {
        font-size: 9.5px !important;
        margin-top: 1px !important;
      }
      .navbar-nav {
        gap: 2px !important;
      }
      .nav-link-custom {
        font-size: 12px !important;
        padding: 6px 7px !important;
        border-radius: 6px !important;
        gap: 2px !important;
      }
      .nav-link-custom .bi-chevron-down {
        font-size: 8px !important;
        margin-left: 1px !important;
      }
      .uis-lang-toggle {
        padding: 5px 8px !important;
        font-size: 11.5px !important;
      }
      .btn-pmb-nav,
      .btn-portal-nav {
        padding: 6px 11px !important;
        font-size: 12px !important;
        border-radius: 7px !important;
        gap: 4px !important;
      }
      .btn-pmb-nav span,
      .btn-portal-nav span {
        font-size: 12px !important;
      }
      .section-heading h2,
      .kerjasama-section-heading h2 {
        font-size: clamp(1.4rem, 1.8vw, 1.75rem) !important;
      }
      .container {
        max-width: 1240px;
      }
      .py-5 {
        padding-top: 2.25rem !important;
        padding-bottom: 2.25rem !important;
      }
    }

    @media (max-height: 800px) and (min-width: 992px) {
      .hero-section,
      .homepage-hero-wrapper {
        min-height: 460px !important;
      }
    }
  </style>

  @include('layouts.frontend.partials.theme-style')

  @stack('styles')
</head>

<body>

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

<!-- Back to Top -->
<a href="#" class="back-to-top" id="backToTop" title="Kembali ke Atas">
  <i class="bi bi-chevron-up"></i>
</a>

<!-- Chat WhatsApp Admin -->
<div id="uis-wa-float-container">
@if(($waAdminSetting->is_active ?? true) && !empty($waAdminSetting->clean_wa))
<a href="{{ $waAdminSetting->wa_url }}"
   target="_blank"
   rel="noopener noreferrer"
   class="uis-wa-float-btn"
   title="{{ $waAdminSetting->nama_admin ?? 'Chat WA Admin' }}">
  <span class="uis-wa-float-icon"><i class="bi bi-whatsapp"></i></span>
  <span>{{ $waAdminSetting->label_tombol ?? 'Chat WA Admin' }}</span>
</a>
@endif
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Swiper Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  AOS.init({
    once: true,
    mirror: false,
    duration: 550,
    easing: 'ease-out',
    offset: 30,
    delay: 0
  });

  // BackToTop
  const btn = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    if (btn) btn.classList.toggle('show', scrollTop > 400);
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
          const newWa = doc.getElementById('uis-wa-float-container');
          const curWa = document.getElementById('uis-wa-float-container');
          if (newWa && curWa) {
            curWa.innerHTML = newWa.innerHTML;
          }
          const newTheme = doc.getElementById('uis-theme-vars');
          const curTheme = document.getElementById('uis-theme-vars');
          if (newTheme && curTheme) {
            curTheme.textContent = newTheme.textContent;
          }
          const newBrand = doc.querySelector('.navbar-main .navbar-brand-custom');
          const curBrand = document.querySelector('.navbar-main .navbar-brand-custom');
          if (newBrand && curBrand) {
            curBrand.innerHTML = newBrand.innerHTML;
          }
          const newFooter = doc.querySelector('footer.footer-main');
          const curFooter = document.querySelector('footer.footer-main');
          if (newFooter && curFooter) {
            curFooter.innerHTML = newFooter.innerHTML;
          }
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
