@php
  $th = $tampilan->header ?? (object) [];
  $tf = $tampilan->footer ?? (object) [];

  // Ambil dari $themeSetting bila ada, atau fallback ke $tampilan / default UIS
  $primaryColor        = $themeSetting->primary_color ?? '#046B26';
  $primaryDarkColor    = $themeSetting->primary_dark_color ?? '#03521d';
  $secondaryColor      = $themeSetting->secondary_color ?? '#FED802';
  $secondaryDarkColor  = $themeSetting->secondary_dark_color ?? '#e5c302';

  $navBg               = $themeSetting->header_bg_color ?? ($th->nav_bg ?? '#046B26');
  $navText             = $themeSetting->header_text_color ?? ($th->nav_text ?? '#ffffff');
  $navBorder           = $themeSetting->header_border_color ?? ($th->nav_accent ?? '#FED802');
  $navActiveBg         = $themeSetting->header_active_bg_color ?? ($th->nav_accent ?? '#FED802');
  $navActiveText       = $themeSetting->header_active_text_color ?? '#046B26';
  $pmbBg               = $themeSetting->header_pmb_bg_color ?? ($th->pmb_bg ?? '#FED802');
  $pmbText             = $themeSetting->header_pmb_text_color ?? ($th->pmb_text ?? '#046B26');
  $loginBg             = $themeSetting->header_login_bg_color ?? '#ffffff';
  $loginText           = $themeSetting->header_login_text_color ?? '#046B26';
  $langBg              = $themeSetting->header_lang_bg_color ?? ($th->lang_bg ?? '#03521d');
  $langText            = $themeSetting->header_lang_text_color ?? ($th->lang_text ?? '#ffffff');
  $headerHeight        = $themeSetting->header_height ?? 90;

  $heroBg              = $themeSetting->hero_bg_color ?? $primaryColor;
  $heroBorder          = $themeSetting->hero_border_color ?? $secondaryColor;

  $fBg                 = $themeSetting->footer_bg_color ?? ($tf->footer_bg ?? '#03521d');
  $fText               = $themeSetting->footer_text_color ?? ($tf->footer_text ?? '#ffffff');
  $fHead               = $themeSetting->footer_heading_color ?? ($tf->footer_heading ?? '#FED802');
  $fBorderTop          = $themeSetting->footer_border_top_color ?? ($tf->footer_accent ?? '#FED802');
  $fLink               = $themeSetting->footer_link_color ?? '#ffffff';
  $fLinkHover          = $themeSetting->footer_link_hover_color ?? ($tf->footer_accent ?? '#FED802');
  $fSocBg              = $themeSetting->footer_social_bg_color ?? ($tf->footer_accent ?? '#FED802');
  $fSocText            = $themeSetting->footer_social_text_color ?? '#046B26';

  $navIsLight = \App\Support\TampilanConfig::isLight($navBg);
@endphp
<style id="uis-theme-vars">
  :root {
    --uis-green: {{ $primaryColor }} !important;
    --uis-green-dark: {{ $primaryDarkColor }} !important;
    --uis-yellow: {{ $secondaryColor }} !important;
    --uis-yellow-hover: {{ $secondaryDarkColor }} !important;
    --uis-purple: {{ $primaryColor }} !important;
    --uis-purple-dark: {{ $primaryDarkColor }} !important;
    --uis-orange: {{ $secondaryColor }} !important;
    --uis-orange-hover: {{ $secondaryDarkColor }} !important;
    --obsidian-dark: {{ $primaryDarkColor }} !important;
    --obsidian-card: {{ $primaryColor }} !important;
  }

  /* Header / Navbar Main */
  .navbar-main {
    background: {{ $navBg }} !important;
    border-bottom: 3px solid {{ $navBorder }} !important;
    min-height: {{ $headerHeight }}px !important;
    padding-top: 14px !important;
    padding-bottom: 14px !important;
  }
  .navbar-main .brand-logo-img {
    height: 52px !important;
    max-height: 52px !important;
  }
  .navbar-main .brand-title-main { color: {{ $navText }} !important; text-shadow: none; }
  .navbar-main .brand-subtitle { color: {{ $navText }} !important; opacity: .82; }
  .navbar-main .navbar-toggler { border-color: {{ $navBorder }} !important; }
  .navbar-main .navbar-toggler-icon { filter: {{ $navIsLight ? 'none' : 'invert(1)' }}; }

  .navbar-main .nav-link-custom {
    color: {{ $navText }} !important;
  }
  .navbar-main .nav-link-custom:hover,
  .navbar-main .nav-link-custom:focus,
  .navbar-main .nav-link-custom.active,
  .navbar-main .nav-link-custom.show,
  .navbar-main .show > .nav-link-custom,
  .navbar-main .nav-item.dropdown:hover > .nav-link-custom {
    background: {{ $navActiveBg }} !important;
    color: {{ $navActiveText }} !important;
  }

  .navbar-main .btn-portal-nav {
    background: {{ $loginBg }} !important;
    color: {{ $loginText }} !important;
    border-color: {{ $loginBg }} !important;
  }
  .navbar-main .btn-portal-nav:hover {
    filter: brightness(0.92);
  }

  .navbar-main .uis-lang-toggle {
    color: {{ $langText }} !important;
    border: 1px solid {{ $navBorder }} !important;
    background: {{ $langBg }} !important;
    border-radius: 999px;
    padding: 6px 14px !important;
    transition: background-color .2s ease, color .2s ease, border-color .2s ease;
  }
  .navbar-main .uis-lang-toggle:hover,
  .navbar-main .show > .uis-lang-toggle {
    background: {{ $navActiveBg }} !important;
    border-color: {{ $navActiveBg }} !important;
    color: {{ $navActiveText }} !important;
  }

  .navbar-main .btn-pmb-nav,
  .navbar-main .btn-pmb-nav i {
    background: {{ $pmbBg }} !important;
    color: {{ $pmbText }} !important;
    border-color: {{ $pmbBg }} !important;
  }
  .navbar-main .btn-pmb-nav:hover,
  .navbar-main .btn-pmb-nav:hover i {
    filter: brightness(0.92);
  }

  /* Dropdown Item Active / Hover Theme Match */
  .navbar-main .dropdown-item-custom:hover,
  .navbar-main .dropdown-item-custom.active,
  .navbar-main .dropdown-item-custom:active {
    background-color: var(--uis-green-light, #eaf6ee) !important;
    color: var(--uis-green, #046b26) !important;
    font-weight: 700 !important;
  }
  .navbar-main .dropdown-item-custom:hover i,
  .navbar-main .dropdown-item-custom.active i,
  .navbar-main .dropdown-item-custom:active i {
    color: var(--uis-green, #046b26) !important;
  }

  /* Subpage Hero Banner Dynamic Overrides */
  .prestasi-hero, .dosen-hero, .news-hero, .article-hero, .about-hero,
  .sejarah-hero, .visimisi-hero, .rektor-hero, .detail-hero, .ormawa-hero,
  .layanan-hero, .galeri-hero, .fasilitas-hero, .kontak-hero, .faq-hero,
  .kerjasama-hero, .tracer-hero, .download-hero, .kurikulum-hero, .hero-subpage,
  .page-hero-banner, .akademik-hero, .sambutan-hero, .struktur-hero,
  .kalender-hero, .akreditasi-hero,
  .testimoni-hero, .humas-hero, .organisasi-hero, .pmb-hero, .profil-hero {
    background: {{ $heroBg }} !important;
    border-bottom: 3px solid {{ $heroBorder }} !important;
  }

  /* Footer Dynamic Overrides */
  .footer-main {
    background: {{ $fBg }} !important;
    color: {{ $fText }} !important;
    border-top: 4px solid {{ $fBorderTop }} !important;
  }
  .footer-main .footer-desc,
  .footer-main .footer-contact-item,
  .footer-main .footer-contact-item span,
  .footer-main .footer-contact-text,
  .footer-main .footer-bottom,
  .footer-main .footer-bottom a {
    color: {{ $fText }} !important;
  }
  .footer-main .footer-heading,
  .footer-main .footer-brand-title,
  .footer-main .footer-logo-text strong,
  .footer-main .footer-contact-text strong {
    color: {{ $fHead }} !important;
  }
  .footer-main .footer-links a {
    color: {{ $fLink }} !important;
  }
  .footer-main .footer-links a:hover,
  .footer-main .footer-contact-icon,
  .footer-main .footer-bottom a:hover,
  .footer-main .footer-bottom a.footer-admin-link {
    color: {{ $fLinkHover }} !important;
  }
  .footer-main .footer-social a {
    background: {{ $fSocBg }} !important;
    color: {{ $fSocText }} !important;
    border: none !important;
  }
  .footer-main .footer-social a:hover {
    filter: brightness(1.1);
  }
  .footer-main .footer-divider {
    background: {{ $fText }}2e !important;
  }
</style>
