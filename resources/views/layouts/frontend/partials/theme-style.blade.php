@php
  $th = $tampilan->header ?? (object) [];
  $tf = $tampilan->footer ?? (object) [];
  $navBg = $th->nav_bg ?? '#046b26';
  $navText = $th->nav_text ?? '#ffffff';
  $navAccent = $th->nav_accent ?? '#fed802';
  $pmbBg = $th->pmb_bg ?? '#ffffff';
  $pmbText = $th->pmb_text ?? '#046b26';
  $langBg = $th->lang_bg ?? '#2e743b';
  $langText = $th->lang_text ?? '#ffffff';
  $langBorder = $th->lang_border ?? '#d6bd36';
  $fBg = $tf->footer_bg ?? '#023814';
  $fText = $tf->footer_text ?? '#e2efe6';
  $fHead = $tf->footer_heading ?? '#ffffff';
  $fAccent = $tf->footer_accent ?? '#fed802';
  $navIsLight = \App\Support\TampilanConfig::isLight($navBg);
@endphp
<style id="uis-theme-vars">
  /* Header / Navbar */
  .navbar-main { background: {{ $navBg }} !important; border-bottom-color: {{ $navAccent }} !important; }
  .navbar-main .brand-title-main { color: {{ $navText }} !important; text-shadow: none; }
  .navbar-main .brand-subtitle { color: {{ $navText }}; opacity: .78; }
  .navbar-main .navbar-toggler { border-color: {{ $navAccent }} !important; }
  .navbar-main .navbar-toggler-icon { filter: {{ $navIsLight ? 'none' : 'invert(1)' }}; }
  @media (min-width: 1200px) {
    .navbar-main .nav-link-custom { color: {{ $navText }} !important; }
    .navbar-main .nav-link-custom:hover,
    .navbar-main .nav-link-custom.active,
    .navbar-main .show > .nav-link-custom { color: {{ $navIsLight ? $navText : $navAccent }} !important; background: {{ $navAccent }}2e !important; }
    .navbar-main .btn-portal-nav { color: {{ $navText }} !important; border-color: {{ $navText }}59 !important; background: {{ $navText }}1f !important; }
    .navbar-main .btn-portal-nav:hover { color: {{ $navAccent }} !important; border-color: {{ $navAccent }} !important; }
  }
  .navbar-main .uis-lang-toggle { color: {{ $langText }} !important; border: 1px solid {{ $langBorder }} !important; background: {{ $langBg }} !important; border-radius: 999px; padding: 6px 12px !important; transition: background-color .2s ease, color .2s ease, border-color .2s ease; }
  .navbar-main .uis-lang-toggle:hover,
  .navbar-main .show > .uis-lang-toggle { background: {{ $langBorder }} !important; border-color: {{ $langBorder }} !important; color: {{ $navBg }} !important; }
  .navbar-main .btn-pmb-nav,
  .navbar-main .btn-pmb-nav i { background: {{ $pmbBg }} !important; color: {{ $pmbText }} !important; border-color: {{ $pmbBg }} !important; }
  .navbar-main .btn-pmb-nav:hover,
  .navbar-main .btn-pmb-nav:hover i { background: {{ $navAccent }} !important; border-color: {{ $navAccent }} !important; color: {{ $navIsLight ? '#ffffff' : $navBg }} !important; }

  /* Footer */
  .footer-main { background: {{ $fBg }} !important; color: {{ $fText }} !important; border-top-color: {{ $fAccent }} !important; }
  .footer-main .footer-desc,
  .footer-main .footer-links a,
  .footer-main .footer-contact-text,
  .footer-main .footer-bottom,
  .footer-main .footer-bottom a { color: {{ $fText }} !important; }
  .footer-main .footer-heading,
  .footer-main .footer-brand-title,
  .footer-main .footer-contact-text strong { color: {{ $fHead }} !important; }
  .footer-main .footer-contact-icon,
  .footer-main .footer-links a:hover,
  .footer-main .footer-bottom a:hover,
  .footer-main .footer-bottom a.footer-admin-link { color: {{ $fAccent }} !important; }
  .footer-main .footer-social a { color: {{ $fHead }} !important; background: {{ $fHead }}1a !important; border-color: {{ $fHead }}33 !important; }
  .footer-main .footer-social a:hover { background: {{ $fAccent }} !important; border-color: {{ $fAccent }} !important; color: {{ $fBg }} !important; }
  .footer-main .footer-divider { background: {{ $fText }}2e !important; }
</style>
