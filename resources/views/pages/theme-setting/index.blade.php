@extends('layouts.dashboard.template')

@section('content')
@php
    $catalog = $catalog ?? \App\Models\ThemeSetting::sectionCatalog();
    $layoutSections = $layoutSections ?? $theme->getLayoutSections();
    $activeTab = $activeTab ?? request('tab', 'header');
    $hiddenCount = collect($layoutSections)->filter(fn ($r) => empty($r['visible']))->count();
@endphp
<div class="pagetitle">
    <h1>Warna Header, Footer, Admin & Tata Letak Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengaturan & Administrator</li>
            <li class="breadcrumb-item active">Warna & Tata Letak Beranda</li>
        </ol>
    </nav>
</div>

<style>
    .theme-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .nav-tabs-theme {
        border-bottom: 2px solid #edf2f7;
        gap: 8px;
    }

    .nav-tabs-theme .nav-link {
        border: none;
        border-radius: 10px 10px 0 0;
        padding: 13px 20px;
        font-weight: 700;
        color: #64748b;
        background: #f8fafc;
        transition: all 0.25s ease;
    }

    .nav-tabs-theme .nav-link.active {
        background: var(--uis-purple, #046B26);
        color: #ffffff;
    }

    .color-picker-group {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 12px;
        transition: all 0.2s ease;
    }

    .color-picker-group:focus-within {
        border-color: var(--uis-purple, #046B26);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.12);
    }

    .color-picker-group input[type="color"] {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 8px;
        padding: 0;
        cursor: pointer;
        background: transparent;
        flex-shrink: 0;
    }

    .color-picker-group input[type="text"] {
        border: none;
        background: transparent;
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        font-size: 0.92rem;
        color: #1e293b;
        width: 100%;
        outline: none;
        text-transform: uppercase;
    }

    .preset-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 50px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 0.79rem;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .preset-badge:hover {
        border-color: var(--uis-purple, #046B26);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .preset-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    /* Live Preview Mockups */
    .preview-browser {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.1);
        background: #f1f5f9;
    }

    .preview-browser-bar {
        background: #1e293b;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .browser-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
    }

    .preview-header-nav {
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
    }

    .preview-footer-box {
        padding: 26px 22px 16px;
        transition: all 0.25s ease;
    }

    .section-divider-title {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #475569;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Tata Letak Beranda Sortable List */
    .tp-layout-list { list-style: none; padding: 0; margin: 0; }
    .tp-layout-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 11px 15px;
        margin-bottom: 9px;
        transition: border-color .2s ease, opacity .2s ease, box-shadow .2s ease;
    }
    .tp-layout-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.04);
    }
    .tp-layout-item.is-hidden { opacity: .55; background: #f8fafc; }
    .tp-layout-item.dragging { box-shadow: 0 10px 24px rgba(15,23,42,.15); border-color: #046b26; }
    .tp-handle { cursor: grab; color: #94a3b8; font-size: 18px; }
    .tp-num {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .tp-sec-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: #ecf8f0;
        color: #046b26;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 16px;
    }
    .tp-move {
        width: 30px;
        height: 30px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
    }
</style>

<section class="section">
    <!-- Quick Global Preset Bar (Frontend + Admin Sekaligus) -->
    <div class="card theme-card mb-3">
        <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-magic me-1"></i> Preset Cepat (Frontend + Admin)</span>
                <span class="text-muted small d-none d-xl-inline">Klik salah satu tema di samping untuk menerapkan warna ke seluruh Website & Panel Admin sekaligus:</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="preset-badge" onclick="applyFullPreset('uis_green')">
                    <span class="preset-dot" style="background: #046B26;"></span>
                    <span class="preset-dot" style="background: #FED802; margin-left:-4px;"></span>
                    Hijau & Kuning UIS (Standar)
                </button>
                <button type="button" class="preset-badge" onclick="applyFullPreset('gold_dark')">
                    <span class="preset-dot" style="background: #111827;"></span>
                    <span class="preset-dot" style="background: #FFD700; margin-left:-4px;"></span>
                    Hitam & Emas Modern
                </button>
                <button type="button" class="preset-badge" onclick="applyFullPreset('navy_blue')">
                    <span class="preset-dot" style="background: #0f172a;"></span>
                    <span class="preset-dot" style="background: #38bdf8; margin-left:-4px;"></span>
                    Biru Navy Akademik
                </button>
                <button type="button" class="preset-badge" onclick="applyFullPreset('emerald_teal')">
                    <span class="preset-dot" style="background: #0f766e;"></span>
                    <span class="preset-dot" style="background: #facc15; margin-left:-4px;"></span>
                    Teal Medis & Kuning
                </button>
            </div>
        </div>
    </div>

    <div class="card theme-card">
        <div class="card-body p-4">

            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs nav-tabs-theme mb-4" id="themeTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'header' ? 'active' : '' }}" id="frontend-header-tab" data-bs-toggle="tab" data-bs-target="#frontend-header-pane" data-tab-name="header" type="button" role="tab">
                        <i class="bi bi-window-dock me-1"></i> 1. Header & Brand Frontend
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'footer' ? 'active' : '' }}" id="frontend-footer-tab" data-bs-toggle="tab" data-bs-target="#frontend-footer-pane" data-tab-name="footer" type="button" role="tab">
                        <i class="bi bi-layout-text-window-reverse me-1"></i> 2. Footer Website
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'admin' ? 'active' : '' }}" id="admin-panel-tab" data-bs-toggle="tab" data-bs-target="#admin-panel-pane" data-tab-name="admin" type="button" role="tab">
                        <i class="bi bi-speedometer2 me-1"></i> 3. Warna Panel Admin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'layout' ? 'active' : '' }}" id="homepage-layout-tab" data-bs-toggle="tab" data-bs-target="#homepage-layout-pane" data-tab-name="layout" type="button" role="tab">
                        <i class="bi bi-arrow-down-up me-1"></i> 4. Tata Letak Beranda
                        <span class="badge bg-warning text-dark ms-1 rounded-pill" style="font-size: 10.5px;">{{ count($catalog) }} Section</span>
                    </button>
                </li>
            </ul>

            <form action="{{ route('theme.update') }}" method="POST" id="themeSettingForm">
                @csrf
                <input type="hidden" name="active_tab" id="active_tab_input" value="{{ $activeTab }}">
                <input type="hidden" name="urutan" id="layoutOrder" value="{{ implode(',', array_keys($layoutSections)) }}">

                <div class="tab-content" id="themeTabContent">

                    <!-- ========================================================= -->
                    <!-- TAB 1: WARNA FRONTEND (BRAND, HEADER & HERO SUBPAGE)       -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $activeTab === 'header' ? 'show active' : '' }}" id="frontend-header-pane" role="tabpanel">

                        <!-- Live Preview Frontend Header & Hero -->
                        <div class="preview-browser mb-4">
                            <div class="preview-browser-bar">
                                <span class="browser-dot" style="background: #ef4444;"></span>
                                <span class="browser-dot" style="background: #f59e0b;"></span>
                                <span class="browser-dot" style="background: #10b981;"></span>
                                <span class="text-white-50 small ms-2 font-monospace">Pratinjau Langsung: Header, Tombol & Hero Halaman Frontend</span>
                            </div>

                            <!-- Navbar Preview -->
                            <div id="pvHeaderNav" class="preview-header-nav" style="background: {{ $theme->header_bg_color }}; border-bottom: 3px solid {{ $theme->header_border_color }};">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('frontend/img/logouis.png') }}" alt="Logo" style="height: 36px;" onerror="this.style.display='none'">
                                    <div style="line-height: 1.15;">
                                        <div id="pvHeaderBrand" style="font-weight: 800; font-size: 0.9rem; color: {{ $theme->header_text_color }};">UNIVERSITAS IBNU SINA</div>
                                        <div id="pvHeaderSubBrand" style="font-size: 0.72rem; opacity: 0.85; color: {{ $theme->header_text_color }};">Unggul, Bermartabat & Berintegritas</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span id="pvMenuActive" style="background: {{ $theme->header_active_bg_color }}; color: {{ $theme->header_active_text_color }}; padding: 5px 13px; border-radius: 50px; font-size: 0.76rem; font-weight: 800;">Beranda</span>
                                    <span class="pvMenuNormal" style="color: {{ $theme->header_text_color }}; padding: 5px 9px; font-size: 0.76rem; font-weight: 600;">Profil</span>
                                    <span class="pvMenuNormal" style="color: {{ $theme->header_text_color }}; padding: 5px 9px; font-size: 0.76rem; font-weight: 600;">Akademik</span>
                                    <span id="pvLangBtn" style="background: {{ $theme->header_lang_bg_color }}; color: {{ $theme->header_lang_text_color }}; padding: 4px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700;">🇮🇩 ID</span>
                                    <span id="pvPmbBtn" style="background: {{ $theme->header_pmb_bg_color }}; color: {{ $theme->header_pmb_text_color }}; padding: 5px 12px; border-radius: 50px; font-size: 0.73rem; font-weight: 800;">Info PMB</span>
                                    <span id="pvLoginBtn" style="background: {{ $theme->header_login_bg_color }}; color: {{ $theme->header_login_text_color }}; padding: 5px 12px; border-radius: 50px; font-size: 0.73rem; font-weight: 800;">Login</span>
                                </div>
                            </div>

                            <!-- Hero Subpage & Accent Preview -->
                            <div id="pvHeroBanner" style="background: {{ $theme->hero_bg_color }}; border-bottom: 4px solid {{ $theme->hero_border_color }}; padding: 20px 24px; color: #fff;">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <span id="pvSecondaryBadge" style="background: {{ $theme->secondary_color }}; color: {{ $theme->primary_color }}; font-size: 0.68rem; font-weight: 800; padding: 3px 10px; border-radius: 50px; text-transform: uppercase;">UNIVERSITAS IBNU SINA</span>
                                        <h6 class="fw-bold mb-0 mt-2 text-white">Banner Hero Halaman & Warna Brand Utama</h6>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span id="pvPrimaryBtn" style="background: {{ $theme->primary_color }}; color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 6px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">Warna Utama</span>
                                        <span id="pvSecondaryBtn" style="background: {{ $theme->secondary_color }}; color: {{ $theme->primary_color }}; padding: 6px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">Warna Aksen</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Brand Utama Website -->
                            <div class="col-12">
                                <div class="section-divider-title"><i class="bi bi-palette2 text-success"></i> A. Warna Brand Utama Website (Global CSS Variables)</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Utama (Primary)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->primary_color }}" data-sync="primary_color">
                                    <input type="text" name="primary_color" id="primary_color" value="{{ $theme->primary_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Utama Gelap (Primary Dark)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->primary_dark_color }}" data-sync="primary_dark_color">
                                    <input type="text" name="primary_dark_color" id="primary_dark_color" value="{{ $theme->primary_dark_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Aksen / Kedua (Secondary)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->secondary_color }}" data-sync="secondary_color">
                                    <input type="text" name="secondary_color" id="secondary_color" value="{{ $theme->secondary_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Aksen Hover (Secondary Dark)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->secondary_dark_color }}" data-sync="secondary_dark_color">
                                    <input type="text" name="secondary_dark_color" id="secondary_dark_color" value="{{ $theme->secondary_dark_color }}">
                                </div>
                            </div>

                            <!-- Navbar Header Utama -->
                            <div class="col-12 mt-4">
                                <div class="section-divider-title"><i class="bi bi-menu-button-wide-fill text-success"></i> B. Warna Navbar Header & Tombol Navigasi</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Header</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_bg_color }}" data-sync="header_bg_color">
                                    <input type="text" name="header_bg_color" id="header_bg_color" value="{{ $theme->header_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Menu & Brand Header</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_text_color }}" data-sync="header_text_color">
                                    <input type="text" name="header_text_color" id="header_text_color" value="{{ $theme->header_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Menu Aktif (Pill)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_active_bg_color }}" data-sync="header_active_bg_color">
                                    <input type="text" name="header_active_bg_color" id="header_active_bg_color" value="{{ $theme->header_active_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Menu Aktif (Pill)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_active_text_color }}" data-sync="header_active_text_color">
                                    <input type="text" name="header_active_text_color" id="header_active_text_color" value="{{ $theme->header_active_text_color }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Garis Bawah Header (Border)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_border_color }}" data-sync="header_border_color">
                                    <input type="text" name="header_border_color" id="header_border_color" value="{{ $theme->header_border_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Tombol Info PMB</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_pmb_bg_color }}" data-sync="header_pmb_bg_color">
                                    <input type="text" name="header_pmb_bg_color" id="header_pmb_bg_color" value="{{ $theme->header_pmb_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Tombol Info PMB</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_pmb_text_color }}" data-sync="header_pmb_text_color">
                                    <input type="text" name="header_pmb_text_color" id="header_pmb_text_color" value="{{ $theme->header_pmb_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Tombol Login</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_login_bg_color }}" data-sync="header_login_bg_color">
                                    <input type="text" name="header_login_bg_color" id="header_login_bg_color" value="{{ $theme->header_login_bg_color }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Tombol Login</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_login_text_color }}" data-sync="header_login_text_color">
                                    <input type="text" name="header_login_text_color" id="header_login_text_color" value="{{ $theme->header_login_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Tombol Bahasa</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_lang_bg_color }}" data-sync="header_lang_bg_color">
                                    <input type="text" name="header_lang_bg_color" id="header_lang_bg_color" value="{{ $theme->header_lang_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Tombol Bahasa</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->header_lang_text_color }}" data-sync="header_lang_text_color">
                                    <input type="text" name="header_lang_text_color" id="header_lang_text_color" value="{{ $theme->header_lang_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Tinggi Header Frontend (px)</label>
                                <div class="input-group">
                                    <input type="number" name="header_height" id="header_height" class="form-control fw-bold" min="60" max="160" value="{{ $theme->header_height ?? 90 }}" style="height: 54px; border-radius: 12px 0 0 12px; border: 1.5px solid #e2e8f0;">
                                    <span class="input-group-text fw-bold bg-light" style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: 0;">px</span>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check form-switch p-3 bg-light rounded-3 border w-100">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="header_is_sticky" id="header_is_sticky" {{ $theme->header_is_sticky ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold small" for="header_is_sticky">
                                        Sticky Header Saat Scroll
                                    </label>
                                </div>
                            </div>

                            <!-- Banner Hero Sub-Halaman -->
                            <div class="col-12 mt-4">
                                <div class="section-divider-title"><i class="bi bi-card-heading text-success"></i> C. Warna Banner Hero Sub-Halaman (Profil, Akademik, Dosen, Berita, dll)</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Background Banner Hero</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->hero_bg_color }}" data-sync="hero_bg_color">
                                    <input type="text" name="hero_bg_color" id="hero_bg_color" value="{{ $theme->hero_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Garis Bawah Banner Hero (Border)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->hero_border_color }}" data-sync="hero_border_color">
                                    <input type="text" name="hero_border_color" id="hero_border_color" value="{{ $theme->hero_border_color }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 2: WARNA FOOTER FRONTEND                              -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $activeTab === 'footer' ? 'show active' : '' }}" id="frontend-footer-pane" role="tabpanel">

                        <!-- Live Preview Footer -->
                        <div class="preview-browser mb-4">
                            <div class="preview-browser-bar">
                                <span class="browser-dot" style="background: #ef4444;"></span>
                                <span class="browser-dot" style="background: #f59e0b;"></span>
                                <span class="browser-dot" style="background: #10b981;"></span>
                                <span class="text-white-50 small ms-2 font-monospace">Pratinjau Langsung: Footer Website Utama</span>
                            </div>
                            <div id="pvFooterBox" class="preview-footer-box" style="background: {{ $theme->footer_bg_color }}; color: {{ $theme->footer_text_color }}; border-top: 4px solid {{ $theme->footer_border_top_color }};">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div id="pvFooterHeading1" style="color: {{ $theme->footer_heading_color }}; font-weight: 800; font-size: 0.95rem; margin-bottom: 6px;">UNIVERSITAS IBNU SINA</div>
                                        <p id="pvFooterDesc" style="font-size: 0.78rem; opacity: 0.9; margin-bottom: 12px; color: {{ $theme->footer_text_color }};">
                                            Mewujudkan Perguruan Tinggi Terkemuka Berdaya Saing Global, Inovatif, dan Berakhlak Mulia.
                                        </p>
                                        <div class="d-flex gap-2">
                                            <span class="pvFooterSocial" style="background: {{ $theme->footer_social_bg_color }}; color: {{ $theme->footer_social_text_color }}; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;"><i class="bi bi-instagram"></i></span>
                                            <span class="pvFooterSocial" style="background: {{ $theme->footer_social_bg_color }}; color: {{ $theme->footer_social_text_color }}; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;"><i class="bi bi-youtube"></i></span>
                                            <span class="pvFooterSocial" style="background: {{ $theme->footer_social_bg_color }}; color: {{ $theme->footer_social_text_color }}; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;"><i class="bi bi-globe"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="pvFooterHeading2" style="color: {{ $theme->footer_heading_color }}; font-weight: 800; font-size: 0.85rem; margin-bottom: 6px;">TAUTAN CEPAT</div>
                                        <div class="d-flex flex-column gap-1" style="font-size: 0.78rem;">
                                            <span class="pvFooterLink" style="color: {{ $theme->footer_link_color }};">› Visi & Misi Universitas</span>
                                            <span class="pvFooterLinkHover" style="color: {{ $theme->footer_link_hover_color }}; font-weight: 700;">› Program Studi (Saat Hover)</span>
                                            <span class="pvFooterLink" style="color: {{ $theme->footer_link_color }};">› Publikasi & Kerjasama</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="pvFooterHeading3" style="color: {{ $theme->footer_heading_color }}; font-weight: 800; font-size: 0.85rem; margin-bottom: 6px;">KONTAK KAMI</div>
                                        <div id="pvFooterContact" style="font-size: 0.76rem; color: {{ $theme->footer_text_color }};">
                                            <div>Jl. Teuku Umar, Lubuk Baja, Kota Batam</div>
                                            <div class="mt-1">info@uis.ac.id</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Utama Footer</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_bg_color }}" data-sync="footer_bg_color">
                                    <input type="text" name="footer_bg_color" id="footer_bg_color" value="{{ $theme->footer_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Garis Atas Footer (Border Top)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_border_top_color }}" data-sync="footer_border_top_color">
                                    <input type="text" name="footer_border_top_color" id="footer_border_top_color" value="{{ $theme->footer_border_top_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Judul Kolom (Heading)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_heading_color }}" data-sync="footer_heading_color">
                                    <input type="text" name="footer_heading_color" id="footer_heading_color" value="{{ $theme->footer_heading_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Teks Deskripsi</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_text_color }}" data-sync="footer_text_color">
                                    <input type="text" name="footer_text_color" id="footer_text_color" value="{{ $theme->footer_text_color }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Tautan / Link Menu</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_link_color }}" data-sync="footer_link_color">
                                    <input type="text" name="footer_link_color" id="footer_link_color" value="{{ $theme->footer_link_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Tautan Saat Hover</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_link_hover_color }}" data-sync="footer_link_hover_color">
                                    <input type="text" name="footer_link_hover_color" id="footer_link_hover_color" value="{{ $theme->footer_link_hover_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Ikon Sosial Media</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_social_bg_color }}" data-sync="footer_social_bg_color">
                                    <input type="text" name="footer_social_bg_color" id="footer_social_bg_color" value="{{ $theme->footer_social_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Ikon Sosial Media</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->footer_social_text_color }}" data-sync="footer_social_text_color">
                                    <input type="text" name="footer_social_text_color" id="footer_social_text_color" value="{{ $theme->footer_social_text_color }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 3: WARNA PANEL ADMIN (DASHBOARD)                      -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $activeTab === 'admin' ? 'show active' : '' }}" id="admin-panel-pane" role="tabpanel">

                        <!-- Live Preview Admin Dashboard -->
                        <div class="preview-browser mb-4">
                            <div class="preview-browser-bar">
                                <span class="browser-dot" style="background: #ef4444;"></span>
                                <span class="browser-dot" style="background: #f59e0b;"></span>
                                <span class="browser-dot" style="background: #10b981;"></span>
                                <span class="text-white-50 small ms-2 font-monospace">Pratinjau Langsung: Header, Sidebar & Tombol Panel Admin</span>
                            </div>

                            <!-- Admin Topbar Preview -->
                            <div id="pvAdminHeader" style="background: {{ $theme->admin_header_bg_color }}; border-bottom: 3px solid {{ $theme->admin_header_border_color }}; padding: 11px 18px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('frontend/img/logouis.png') }}" alt="Logo" style="height: 28px;" onerror="this.style.display='none'">
                                    <span id="pvAdminBrand" style="color: {{ $theme->admin_header_brand_color }}; font-weight: 800; font-size: 0.9rem;">Portal UIS</span>
                                    <i id="pvAdminToggle" class="bi bi-list ms-2" style="color: {{ $theme->admin_header_text_color }}; font-size: 1.2rem;"></i>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span id="pvAdminUser" style="color: {{ $theme->admin_header_text_color }}; font-size: 0.78rem; font-weight: 700;">
                                        <i class="bi bi-person-circle me-1"></i> Administrator
                                    </span>
                                </div>
                            </div>

                            <!-- Admin Sidebar + Main Content Preview -->
                            <div class="d-flex" style="min-height: 170px;">
                                <!-- Sidebar Preview -->
                                <div id="pvAdminSidebar" style="width: 220px; background: {{ $theme->admin_sidebar_bg_color }}; padding: 12px; border-right: 1px solid #e2e8f0;">
                                    <div id="pvAdminMenuActive" style="background: {{ $theme->admin_sidebar_active_bg_color }}; color: {{ $theme->admin_sidebar_active_text_color }}; border-left: 4px solid {{ $theme->admin_accent_color }}; padding: 8px 11px; border-radius: 7px; font-size: 0.78rem; font-weight: 800; margin-bottom: 6px;">
                                        <i class="bi bi-grid me-2"></i> Dashboard
                                    </div>
                                    <div class="pvAdminMenuNormal" style="color: {{ $theme->admin_sidebar_text_color }}; padding: 7px 11px; border-radius: 7px; font-size: 0.77rem; font-weight: 600; margin-bottom: 4px;">
                                        <i class="bi bi-house-heart me-2"></i> Konten Beranda
                                    </div>
                                    <div id="pvAdminMenuHover" style="background: {{ $theme->admin_sidebar_hover_bg_color }}; color: {{ $theme->admin_sidebar_hover_text_color }}; padding: 7px 11px; border-radius: 7px; font-size: 0.77rem; font-weight: 700; margin-bottom: 4px;">
                                        <i class="bi bi-palette-fill me-2"></i> Warna Frontend & Admin
                                    </div>
                                    <div class="pvAdminMenuNormal" style="color: {{ $theme->admin_sidebar_text_color }}; padding: 7px 11px; border-radius: 7px; font-size: 0.77rem; font-weight: 600;">
                                        <i class="bi bi-hdd-network me-2"></i> Backup Database
                                    </div>
                                </div>

                                <!-- Content Area Preview -->
                                <div class="flex-grow-1 p-3" style="background: #f8fafc;">
                                    <div class="bg-white p-3 rounded-3 shadow-sm border">
                                        <h6 id="pvAdminCardTitle" style="color: {{ $theme->admin_primary_color }}; font-weight: 800; font-size: 0.88rem; margin-bottom: 6px;">Contoh Card & Tombol di Panel Admin</h6>
                                        <p class="text-muted small mb-3" style="font-size: 0.76rem;">Warna tombol utama, judul halaman, dan aksen di seluruh halaman dashboard akan mengikuti pengaturan di bawah ini.</p>
                                        <div class="d-flex gap-2">
                                            <span id="pvAdminBtnPrimary" style="background: {{ $theme->admin_primary_color }}; color: #fff; padding: 6px 14px; border-radius: 7px; font-size: 0.75rem; font-weight: 700;">Tombol Utama Admin</span>
                                            <span id="pvAdminBtnAccent" style="background: {{ $theme->admin_accent_color }}; color: #111; padding: 6px 14px; border-radius: 7px; font-size: 0.75rem; font-weight: 800;">Tombol Aksen / Kuning</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="section-divider-title"><i class="bi bi-window-Stack text-success"></i> A. Warna Topbar Header Admin & Tombol Utama</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Utama Admin (Primary)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_primary_color }}" data-sync="admin_primary_color">
                                    <input type="text" name="admin_primary_color" id="admin_primary_color" value="{{ $theme->admin_primary_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Aksen Admin (Accent)</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_accent_color }}" data-sync="admin_accent_color">
                                    <input type="text" name="admin_accent_color" id="admin_accent_color" value="{{ $theme->admin_accent_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Header Admin</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_header_bg_color }}" data-sync="admin_header_bg_color">
                                    <input type="text" name="admin_header_bg_color" id="admin_header_bg_color" value="{{ $theme->admin_header_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Brand Logo Admin</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_header_brand_color }}" data-sync="admin_header_brand_color">
                                    <input type="text" name="admin_header_brand_color" id="admin_header_brand_color" value="{{ $theme->admin_header_brand_color }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks & Ikon Header Admin</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_header_text_color }}" data-sync="admin_header_text_color">
                                    <input type="text" name="admin_header_text_color" id="admin_header_text_color" value="{{ $theme->admin_header_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Garis Bawah Header Admin</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_header_border_color }}" data-sync="admin_header_border_color">
                                    <input type="text" name="admin_header_border_color" id="admin_header_border_color" value="{{ $theme->admin_header_border_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Tinggi Header Admin (px)</label>
                                <div class="input-group">
                                    <input type="number" name="admin_header_height" id="admin_header_height" class="form-control fw-bold" min="56" max="140" value="{{ $theme->admin_header_height ?? 78 }}" style="height: 54px; border-radius: 12px 0 0 12px; border: 1.5px solid #e2e8f0;">
                                    <span class="input-group-text fw-bold bg-light" style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: 0;">px</span>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="section-divider-title"><i class="bi bi-layout-sidebar-inset text-success"></i> B. Warna Sidebar Menu Admin</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Sidebar Admin</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_bg_color }}" data-sync="admin_sidebar_bg_color">
                                    <input type="text" name="admin_sidebar_bg_color" id="admin_sidebar_bg_color" value="{{ $theme->admin_sidebar_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Warna Teks Menu Sidebar</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_text_color }}" data-sync="admin_sidebar_text_color">
                                    <input type="text" name="admin_sidebar_text_color" id="admin_sidebar_text_color" value="{{ $theme->admin_sidebar_text_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Menu Aktif Sidebar</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_active_bg_color }}" data-sync="admin_sidebar_active_bg_color">
                                    <input type="text" name="admin_sidebar_active_bg_color" id="admin_sidebar_active_bg_color" value="{{ $theme->admin_sidebar_active_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Menu Aktif Sidebar</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_active_text_color }}" data-sync="admin_sidebar_active_text_color">
                                    <input type="text" name="admin_sidebar_active_text_color" id="admin_sidebar_active_text_color" value="{{ $theme->admin_sidebar_active_text_color }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Background Menu Saat Hover</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_hover_bg_color }}" data-sync="admin_sidebar_hover_bg_color">
                                    <input type="text" name="admin_sidebar_hover_bg_color" id="admin_sidebar_hover_bg_color" value="{{ $theme->admin_sidebar_hover_bg_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Teks Menu Saat Hover</label>
                                <div class="color-picker-group">
                                    <input type="color" value="{{ $theme->admin_sidebar_hover_text_color }}" data-sync="admin_sidebar_hover_text_color">
                                    <input type="text" name="admin_sidebar_hover_text_color" id="admin_sidebar_hover_text_color" value="{{ $theme->admin_sidebar_hover_text_color }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 4: TATA LETAK BERANDA (URUTAN & VISIBILITAS 16 SECTION) -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $activeTab === 'layout' ? 'show active' : '' }}" id="homepage-layout-pane" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="p-3 p-md-4 bg-white rounded-4 border">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">
                                                <i class="bi bi-arrow-down-up text-primary me-2"></i>Urutan Section Halaman Beranda
                                            </h6>
                                            <div class="text-muted" style="font-size: 12.5px;">
                                                Seret ikon <i class="bi bi-grip-vertical"></i> atau gunakan tombol panah untuk mengubah urutan. Matikan sakelar untuk menyembunyikan section.
                                            </div>
                                        </div>
                                        <span class="badge bg-light text-dark border px-3 py-2" id="layoutCounter" style="font-size: 12px; border-radius: 8px;">
                                            {{ count($catalog) - $hiddenCount }} tampil · {{ $hiddenCount }} disembunyikan
                                        </span>
                                    </div>

                                    <ul class="tp-layout-list" id="layoutList">
                                        @foreach($layoutSections as $key => $row)
                                            @php
                                                $meta = $catalog[$key] ?? ['label' => $key, 'icon' => 'bi-square'];
                                            @endphp
                                            <li class="tp-layout-item {{ empty($row['visible']) ? 'is-hidden' : '' }}" data-key="{{ $key }}" draggable="true">
                                                <i class="bi bi-grip-vertical tp-handle" title="Tahan & geser untuk mengubah urutan"></i>
                                                <span class="tp-num">{{ $loop->iteration }}</span>
                                                <span class="tp-sec-icon"><i class="bi {{ $meta['icon'] }}"></i></span>
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="fw-bold text-dark" style="font-size: 13.5px;">{{ $meta['label'] }}</div>
                                                    <div class="text-muted" style="font-size: 11px;">#{{ $key }}</div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-light border tp-move" data-move="up" title="Naikkan"><i class="bi bi-chevron-up"></i></button>
                                                <button type="button" class="btn btn-sm btn-light border tp-move" data-move="down" title="Turunkan"><i class="bi bi-chevron-down"></i></button>
                                                <div class="form-check form-switch mb-0 ms-1" title="Tampilkan / sembunyikan">
                                                    <input class="form-check-input tp-visible" type="checkbox" role="switch" name="visible[{{ $key }}]" value="1" {{ !empty($row['visible']) ? 'checked' : '' }}>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="p-3 p-md-4 bg-white rounded-4 border">
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 15px;">
                                        <i class="bi bi-info-circle text-success me-2"></i>Catatan
                                    </h6>
                                    <ul class="small text-secondary ps-3 mb-3" style="line-height: 1.65;">
                                        <li class="mb-2">Perubahan langsung diterapkan ke halaman beranda setelah disimpan, tanpa perlu memuat ulang.</li>
                                        <li class="mb-2">Section yang disembunyikan tidak dihapus — isi kontennya tetap tersimpan dan dapat ditampilkan kembali kapan saja.</li>
                                        <li>Isi tiap section tetap dikelola melalui menu <strong>Konten Beranda</strong> masing-masing.</li>
                                    </ul>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success fw-bold py-2" style="background-color: #3b7a57; border-color: #3b7a57;">
                                            <i class="bi bi-box-arrow-in-down me-1"></i> Simpan Tata Letak
                                        </button>
                                        <a href="{{ route('homepage') }}" target="_blank" class="btn btn-outline-success fw-semibold py-2">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Beranda
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary fw-semibold py-2" onclick="if(confirm('Kembalikan urutan & visibilitas section ke bawaan?')) document.getElementById('resetLayoutForm').submit();">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Urutan Default
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" onclick="if(confirm('Kembalikan seluruh warna & tata letak ke standar awal?')) document.getElementById('resetThemeForm').submit();">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Semua ke Standar Awal
                    </button>

                    <div class="d-flex gap-2">
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Frontend
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <form action="{{ route('theme.reset') }}" method="POST" id="resetThemeForm" class="d-none">
                @csrf
            </form>
            <form action="{{ route('theme.reset-layout') }}" method="POST" id="resetLayoutForm" class="d-none">
                @csrf
            </form>

        </div>
    </div>
</section>

<script>
    function setColorVal(id, color) {
        const textInput = document.getElementById(id);
        const colorInput = document.querySelector(`input[type="color"][data-sync="${id}"]`);
        if (textInput) textInput.value = color;
        if (colorInput && /^#[0-9A-Fa-f]{6}$/.test(color)) colorInput.value = color;
    }

    function updateLivePreview() {
        // 1. Frontend Header & Hero
        const primary = document.getElementById('primary_color').value;
        const secondary = document.getElementById('secondary_color').value;
        const hBg = document.getElementById('header_bg_color').value;
        const hText = document.getElementById('header_text_color').value;
        const hActBg = document.getElementById('header_active_bg_color').value;
        const hActText = document.getElementById('header_active_text_color').value;
        const hPmbBg = document.getElementById('header_pmb_bg_color').value;
        const hPmbText = document.getElementById('header_pmb_text_color').value;
        const hLoginBg = document.getElementById('header_login_bg_color').value;
        const hLoginText = document.getElementById('header_login_text_color').value;
        const hLangBg = document.getElementById('header_lang_bg_color').value;
        const hLangText = document.getElementById('header_lang_text_color').value;
        const hBorder = document.getElementById('header_border_color').value;
        const heroBg = document.getElementById('hero_bg_color').value;
        const heroBorder = document.getElementById('hero_border_color').value;

        const pvNav = document.getElementById('pvHeaderNav');
        pvNav.style.background = hBg;
        pvNav.style.borderBottom = `3px solid ${hBorder}`;
        document.getElementById('pvHeaderBrand').style.color = hText;
        document.getElementById('pvHeaderSubBrand').style.color = hText;
        document.querySelectorAll('.pvMenuNormal').forEach(el => el.style.color = hText);

        const pvActive = document.getElementById('pvMenuActive');
        pvActive.style.background = hActBg;
        pvActive.style.color = hActText;

        const pvLang = document.getElementById('pvLangBtn');
        pvLang.style.background = hLangBg;
        pvLang.style.color = hLangText;

        const pvPmb = document.getElementById('pvPmbBtn');
        pvPmb.style.background = hPmbBg;
        pvPmb.style.color = hPmbText;

        const pvLogin = document.getElementById('pvLoginBtn');
        pvLogin.style.background = hLoginBg;
        pvLogin.style.color = hLoginText;

        const pvHero = document.getElementById('pvHeroBanner');
        pvHero.style.background = heroBg;
        pvHero.style.borderBottom = `4px solid ${heroBorder}`;

        const pvSecBadge = document.getElementById('pvSecondaryBadge');
        pvSecBadge.style.background = secondary;
        pvSecBadge.style.color = primary;

        document.getElementById('pvPrimaryBtn').style.background = primary;
        const pvSecBtn = document.getElementById('pvSecondaryBtn');
        pvSecBtn.style.background = secondary;
        pvSecBtn.style.color = primary;

        // 2. Frontend Footer
        const fBg = document.getElementById('footer_bg_color').value;
        const fBorder = document.getElementById('footer_border_top_color').value;
        const fHead = document.getElementById('footer_heading_color').value;
        const fText = document.getElementById('footer_text_color').value;
        const fLink = document.getElementById('footer_link_color').value;
        const fLinkHover = document.getElementById('footer_link_hover_color').value;
        const fSocBg = document.getElementById('footer_social_bg_color').value;
        const fSocText = document.getElementById('footer_social_text_color').value;

        const pvFooter = document.getElementById('pvFooterBox');
        pvFooter.style.background = fBg;
        pvFooter.style.color = fText;
        pvFooter.style.borderTop = `4px solid ${fBorder}`;
        document.getElementById('pvFooterHeading1').style.color = fHead;
        document.getElementById('pvFooterHeading2').style.color = fHead;
        document.getElementById('pvFooterHeading3').style.color = fHead;
        document.getElementById('pvFooterDesc').style.color = fText;
        document.getElementById('pvFooterContact').style.color = fText;
        document.querySelectorAll('.pvFooterLink').forEach(el => el.style.color = fLink);
        document.querySelectorAll('.pvFooterLinkHover').forEach(el => el.style.color = fLinkHover);
        document.querySelectorAll('.pvFooterSocial').forEach(el => {
            el.style.background = fSocBg;
            el.style.color = fSocText;
        });

        // 3. Admin Panel
        const aPrimary = document.getElementById('admin_primary_color').value;
        const aAccent = document.getElementById('admin_accent_color').value;
        const aHeaderBg = document.getElementById('admin_header_bg_color').value;
        const aHeaderText = document.getElementById('admin_header_text_color').value;
        const aHeaderBrand = document.getElementById('admin_header_brand_color').value;
        const aHeaderBorder = document.getElementById('admin_header_border_color').value;
        const aSideBg = document.getElementById('admin_sidebar_bg_color').value;
        const aSideText = document.getElementById('admin_sidebar_text_color').value;
        const aSideActBg = document.getElementById('admin_sidebar_active_bg_color').value;
        const aSideActText = document.getElementById('admin_sidebar_active_text_color').value;
        const aSideHovBg = document.getElementById('admin_sidebar_hover_bg_color').value;
        const aSideHovText = document.getElementById('admin_sidebar_hover_text_color').value;

        const pvAdminHeader = document.getElementById('pvAdminHeader');
        pvAdminHeader.style.background = aHeaderBg;
        pvAdminHeader.style.borderBottom = `3px solid ${aHeaderBorder}`;
        document.getElementById('pvAdminBrand').style.color = aHeaderBrand;
        document.getElementById('pvAdminToggle').style.color = aHeaderText;
        document.getElementById('pvAdminUser').style.color = aHeaderText;

        document.getElementById('pvAdminSidebar').style.background = aSideBg;
        document.querySelectorAll('.pvAdminMenuNormal').forEach(el => el.style.color = aSideText);

        const pvAdminAct = document.getElementById('pvAdminMenuActive');
        pvAdminAct.style.background = aSideActBg;
        pvAdminAct.style.color = aSideActText;
        pvAdminAct.style.borderLeft = `4px solid ${aAccent}`;

        const pvAdminHov = document.getElementById('pvAdminMenuHover');
        pvAdminHov.style.background = aSideHovBg;
        pvAdminHov.style.color = aSideHovText;

        document.getElementById('pvAdminCardTitle').style.color = aPrimary;
        document.getElementById('pvAdminBtnPrimary').style.background = aPrimary;
        document.getElementById('pvAdminBtnAccent').style.background = aAccent;

        const currentLayout = {};
        document.querySelectorAll('#layoutList .tp-layout-item').forEach((li, idx) => {
            const key = li.dataset.key;
            const cb = li.querySelector('.tp-visible');
            if (key) {
                currentLayout[key] = {
                    order: idx + 1,
                    visible: cb ? cb.checked : true
                };
            }
        });

        // Live broadcast to Frontend & Admin Panel without page reload
        const liveTheme = {
            primary_color: primary,
            primary_dark_color: document.getElementById('primary_dark_color').value,
            secondary_color: secondary,
            secondary_dark_color: document.getElementById('secondary_dark_color').value,
            header_bg_color: hBg,
            header_text_color: hText,
            header_active_bg_color: hActBg,
            header_active_text_color: hActText,
            header_pmb_bg_color: hPmbBg,
            header_pmb_text_color: hPmbText,
            header_login_bg_color: hLoginBg,
            header_login_text_color: hLoginText,
            header_lang_bg_color: hLangBg,
            header_lang_text_color: hLangText,
            header_border_color: hBorder,
            header_height: document.getElementById('header_height') ? document.getElementById('header_height').value : 90,
            header_is_sticky: document.getElementById('header_is_sticky') ? document.getElementById('header_is_sticky').checked : true,
            hero_bg_color: heroBg,
            hero_border_color: heroBorder,
            footer_bg_color: fBg,
            footer_text_color: fText,
            footer_heading_color: fHead,
            footer_border_top_color: fBorder,
            footer_link_color: fLink,
            footer_link_hover_color: fLinkHover,
            footer_social_bg_color: fSocBg,
            footer_social_text_color: fSocText,
            admin_primary_color: aPrimary,
            admin_accent_color: aAccent,
            admin_header_bg_color: aHeaderBg,
            admin_header_text_color: aHeaderText,
            admin_header_brand_color: aHeaderBrand,
            admin_header_border_color: aHeaderBorder,
            admin_header_height: document.getElementById('admin_header_height') ? document.getElementById('admin_header_height').value : 78,
            admin_sidebar_bg_color: aSideBg,
            admin_sidebar_text_color: aSideText,
            admin_sidebar_active_bg_color: aSideActBg,
            admin_sidebar_active_text_color: aSideActText,
            admin_sidebar_hover_bg_color: aSideHovBg,
            admin_sidebar_hover_text_color: aSideHovText,
            layout: currentLayout
        };

        if (typeof window.applyLiveAdminTheme === 'function') {
            window.applyLiveAdminTheme(liveTheme);
        }

        try {
            if ('BroadcastChannel' in window) {
                if (!window._webuisThemeBc) {
                    window._webuisThemeBc = new BroadcastChannel('webuis_live_sync');
                }
                window._webuisThemeBc.postMessage({ type: 'theme_update', theme: liveTheme, ts: Date.now() });
            }
            localStorage.setItem('webuis_live_theme', JSON.stringify({ theme: liveTheme, ts: Date.now() }));
        } catch (e) {}
    }

    ['header_height', 'admin_header_height', 'header_is_sticky'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateLivePreview);
            el.addEventListener('change', updateLivePreview);
        }
    });

    document.querySelectorAll('input[type="color"][data-sync]').forEach(picker => {
        picker.addEventListener('input', function () {
            const targetId = this.getAttribute('data-sync');
            document.getElementById(targetId).value = this.value;
            updateLivePreview();
        });
    });

    document.querySelectorAll('.color-picker-group input[type="text"]').forEach(txt => {
        txt.addEventListener('input', function () {
            const picker = document.querySelector(`input[type="color"][data-sync="${this.id}"]`);
            if (picker && /^#[0-9A-Fa-f]{6}$/.test(this.value.trim())) {
                picker.value = this.value.trim();
            }
            updateLivePreview();
        });
    });

    const fullPresets = {
        uis_green: {
            primary_color: '#046B26', primary_dark_color: '#03521d', secondary_color: '#FED802', secondary_dark_color: '#e5c302',
            header_bg_color: '#046B26', header_text_color: '#ffffff', header_active_bg_color: '#FED802', header_active_text_color: '#046B26',
            header_pmb_bg_color: '#FED802', header_pmb_text_color: '#046B26', header_login_bg_color: '#ffffff', header_login_text_color: '#046B26',
            header_lang_bg_color: '#03521d', header_lang_text_color: '#ffffff', header_border_color: '#FED802',
            hero_bg_color: '#046B26', hero_border_color: '#FED802',
            footer_bg_color: '#03521d', footer_text_color: '#ffffff', footer_heading_color: '#FED802', footer_border_top_color: '#FED802',
            footer_link_color: '#ffffff', footer_link_hover_color: '#FED802', footer_social_bg_color: '#FED802', footer_social_text_color: '#046B26',
            admin_primary_color: '#046B26', admin_accent_color: '#FED802', admin_header_bg_color: '#046B26', admin_header_text_color: '#ffffff',
            admin_header_brand_color: '#FED802', admin_header_border_color: '#FED802', admin_sidebar_bg_color: '#ffffff', admin_sidebar_text_color: '#046B26',
            admin_sidebar_active_bg_color: '#eaf6ee', admin_sidebar_active_text_color: '#046B26', admin_sidebar_hover_bg_color: '#f8fcf9', admin_sidebar_hover_text_color: '#FED802'
        },
        gold_dark: {
            primary_color: '#111827', primary_dark_color: '#090d16', secondary_color: '#FFD700', secondary_dark_color: '#e6c200',
            header_bg_color: '#FFD700', header_text_color: '#111827', header_active_bg_color: '#111827', header_active_text_color: '#FFD700',
            header_pmb_bg_color: '#111827', header_pmb_text_color: '#FFD700', header_login_bg_color: '#ffffff', header_login_text_color: '#111827',
            header_lang_bg_color: '#111827', header_lang_text_color: '#FFD700', header_border_color: '#111827',
            hero_bg_color: '#111827', hero_border_color: '#FFD700',
            footer_bg_color: '#0b0f19', footer_text_color: '#cbd5e1', footer_heading_color: '#FFD700', footer_border_top_color: '#FFD700',
            footer_link_color: '#cbd5e1', footer_link_hover_color: '#FFD700', footer_social_bg_color: '#FFD700', footer_social_text_color: '#111827',
            admin_primary_color: '#111827', admin_accent_color: '#FFD700', admin_header_bg_color: '#FFD700', admin_header_text_color: '#111827',
            admin_header_brand_color: '#111827', admin_header_border_color: '#111827', admin_sidebar_bg_color: '#ffffff', admin_sidebar_text_color: '#111827',
            admin_sidebar_active_bg_color: '#FFD700', admin_sidebar_active_text_color: '#111827', admin_sidebar_hover_bg_color: '#fffbeb', admin_sidebar_hover_text_color: '#111827'
        },
        navy_blue: {
            primary_color: '#0f172a', primary_dark_color: '#020617', secondary_color: '#38bdf8', secondary_dark_color: '#0284c7',
            header_bg_color: '#0f172a', header_text_color: '#f8fafc', header_active_bg_color: '#38bdf8', header_active_text_color: '#0f172a',
            header_pmb_bg_color: '#38bdf8', header_pmb_text_color: '#0f172a', header_login_bg_color: '#ffffff', header_login_text_color: '#0f172a',
            header_lang_bg_color: '#1e293b', header_lang_text_color: '#38bdf8', header_border_color: '#38bdf8',
            hero_bg_color: '#0f172a', hero_border_color: '#38bdf8',
            footer_bg_color: '#020617', footer_text_color: '#94a3b8', footer_heading_color: '#38bdf8', footer_border_top_color: '#38bdf8',
            footer_link_color: '#cbd5e1', footer_link_hover_color: '#38bdf8', footer_social_bg_color: '#38bdf8', footer_social_text_color: '#0f172a',
            admin_primary_color: '#0f172a', admin_accent_color: '#38bdf8', admin_header_bg_color: '#0f172a', admin_header_text_color: '#f8fafc',
            admin_header_brand_color: '#38bdf8', admin_header_border_color: '#38bdf8', admin_sidebar_bg_color: '#ffffff', admin_sidebar_text_color: '#0f172a',
            admin_sidebar_active_bg_color: '#e0f2fe', admin_sidebar_active_text_color: '#0369a1', admin_sidebar_hover_bg_color: '#f0f9ff', admin_sidebar_hover_text_color: '#0284c7'
        },
        emerald_teal: {
            primary_color: '#0f766e', primary_dark_color: '#115e59', secondary_color: '#facc15', secondary_dark_color: '#eab308',
            header_bg_color: '#0f766e', header_text_color: '#ffffff', header_active_bg_color: '#facc15', header_active_text_color: '#134e4a',
            header_pmb_bg_color: '#facc15', header_pmb_text_color: '#134e4a', header_login_bg_color: '#ffffff', header_login_text_color: '#0f766e',
            header_lang_bg_color: '#115e59', header_lang_text_color: '#ffffff', header_border_color: '#facc15',
            hero_bg_color: '#0f766e', hero_border_color: '#facc15',
            footer_bg_color: '#134e4a', footer_text_color: '#f0fdfa', footer_heading_color: '#facc15', footer_border_top_color: '#facc15',
            footer_link_color: '#ccfbf1', footer_link_hover_color: '#facc15', footer_social_bg_color: '#facc15', footer_social_text_color: '#134e4a',
            admin_primary_color: '#0f766e', admin_accent_color: '#facc15', admin_header_bg_color: '#0f766e', admin_header_text_color: '#ffffff',
            admin_header_brand_color: '#facc15', admin_header_border_color: '#facc15', admin_sidebar_bg_color: '#ffffff', admin_sidebar_text_color: '#0f766e',
            admin_sidebar_active_bg_color: '#ccfbf1', admin_sidebar_active_text_color: '#0f766e', admin_sidebar_hover_bg_color: '#f0fdfa', admin_sidebar_hover_text_color: '#0d9488'
        }
    };

    function applyFullPreset(key) {
        const preset = fullPresets[key];
        if (!preset) return;
        Object.keys(preset).forEach(field => setColorVal(field, preset[field]));
        updateLivePreview();
    }

    // ── Tab State Sync (?tab=header|footer|admin|layout)
    document.querySelectorAll('#themeTab button[data-tab-name]').forEach(btn => {
        btn.addEventListener('shown.bs.tab', () => {
            const tabName = btn.getAttribute('data-tab-name') || 'header';
            const activeTabInput = document.getElementById('active_tab_input');
            if (activeTabInput) activeTabInput.value = tabName;
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabName);
            history.replaceState(null, '', url);
        });
    });

    // ── Tata Letak Beranda: Drag & Drop + Tombol Naik/Turun + Toggle Visibilitas
    (function () {
        const list = document.getElementById('layoutList');
        const orderInput = document.getElementById('layoutOrder');
        const counter = document.getElementById('layoutCounter');
        if (!list) return;

        function refreshLayout(broadcast = true) {
            const items = [...list.querySelectorAll('.tp-layout-item')];
            items.forEach((li, i) => {
                const numEl = li.querySelector('.tp-num');
                const cb = li.querySelector('.tp-visible');
                if (numEl) numEl.textContent = i + 1;
                if (cb) li.classList.toggle('is-hidden', !cb.checked);
            });
            if (orderInput) {
                orderInput.value = items.map(li => li.dataset.key).join(',');
            }
            if (counter) {
                const shown = items.filter(li => li.querySelector('.tp-visible')?.checked).length;
                counter.textContent = shown + ' tampil · ' + (items.length - shown) + ' disembunyikan';
            }
            if (broadcast) {
                updateLivePreview();
            }
        }

        list.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-move]');
            if (!btn) return;
            const li = btn.closest('.tp-layout-item');
            if (btn.dataset.move === 'up' && li.previousElementSibling) {
                list.insertBefore(li, li.previousElementSibling);
            } else if (btn.dataset.move === 'down' && li.nextElementSibling) {
                list.insertBefore(li.nextElementSibling, li);
            }
            refreshLayout(true);
        });

        list.addEventListener('change', (e) => {
            if (e.target.classList.contains('tp-visible')) {
                refreshLayout(true);
            }
        });

        let dragged = null;
        list.addEventListener('dragstart', (e) => {
            dragged = e.target.closest('.tp-layout-item');
            if (!dragged) return;
            dragged.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        list.addEventListener('dragend', () => {
            if (dragged) dragged.classList.remove('dragging');
            dragged = null;
            refreshLayout(true);
        });

        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            if (!dragged) return;
            const after = [...list.querySelectorAll('.tp-layout-item:not(.dragging)')].find(li => {
                const box = li.getBoundingClientRect();
                return e.clientY < box.top + box.height / 2;
            });
            if (after) list.insertBefore(dragged, after);
            else list.appendChild(dragged);
        });

        refreshLayout(false);
    })();
</script>
@endsection
