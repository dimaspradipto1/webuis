@extends('layouts.dashboard.template')

@section('content')
@php
  $h = $tampilan->header;
  $f = $tampilan->footer;
  $headerColors = [
      'nav_bg' => ['Warna Background Navbar Header', 'Latar belakang bar navigasi utama'],
      'nav_text' => ['Warna Teks Judul & Menu Normal', 'Teks logo, judul dan item menu'],
      'nav_accent' => ['Warna Aksen (Menu Aktif & Garis Bawah)', 'Menu aktif, hover dan garis bawah header'],
      'pmb_bg' => ['Warna Background Tombol PMB', 'Tombol pendaftaran di kanan header'],
      'pmb_text' => ['Warna Teks Tombol PMB', 'Teks dan ikon tombol PMB'],
  ];
  $footerColors = [
      'footer_bg' => ['Warna Background Footer', 'Latar belakang area footer'],
      'footer_text' => ['Warna Teks Isi Footer', 'Deskripsi, tautan dan kontak'],
      'footer_heading' => ['Warna Judul Kolom Footer', 'Judul kolom dan nama kampus'],
      'footer_accent' => ['Warna Aksen Footer', 'Ikon kontak, hover tautan dan garis atas'],
  ];
  $hiddenCount = collect($tampilan->layout)->filter(fn ($r) => empty($r['visible']))->count();
@endphp

<style>
  .tp-tabs { background: #fff; border-radius: 14px; padding: 6px; box-shadow: 0 1px 3px rgba(15,23,42,.06); display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; }
  .tp-tab { border: 0; background: transparent; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: center; gap: 12px; text-align: left; color: #334155; transition: background-color .2s ease, color .2s ease; }
  .tp-tab i { font-size: 18px; }
  .tp-tab strong { display: block; font-size: 14px; }
  .tp-tab small { display: block; font-size: 11px; color: #94a3b8; }
  .tp-tab:hover { background: #f1f5f9; }
  .tp-tab.active { background: #0f172a; color: #fff; }
  .tp-tab.active i { color: #facc15; }
  .tp-tab.active small { color: #cbd5e1; }

  .tp-browser { border-radius: 14px; overflow: hidden; background: #111827; box-shadow: 0 10px 30px rgba(15,23,42,.18); }
  .tp-browser-bar { display: flex; align-items: center; gap: 14px; padding: 10px 16px; }
  .tp-dots span { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
  .tp-url { flex: 1; max-width: 300px; margin: 0 auto; background: #1f2937; color: #cbd5e1; border-radius: 8px; padding: 4px 12px; font-size: 11.5px; text-align: center; }
  .tp-live { font-size: 10.5px; font-weight: 700; color: #facc15; border: 1px solid #facc1566; border-radius: 999px; padding: 3px 10px; letter-spacing: .4px; }

  .pv-nav { background: var(--pv-nav-bg); border-bottom: 3px solid var(--pv-nav-accent); padding: 14px 20px; display: flex; align-items: center; gap: 18px; transition: background-color .2s ease; }
  .pv-brand { display: flex; align-items: center; gap: 10px; color: var(--pv-nav-text); min-width: 0; }
  .pv-brand img { height: 38px; width: auto; object-fit: contain; }
  .pv-brand-title { font-weight: 800; font-size: 13.5px; letter-spacing: .4px; line-height: 1.1; white-space: nowrap; }
  .pv-brand-sub { font-size: 10.5px; opacity: .8; white-space: nowrap; }
  .pv-menu { display: flex; gap: 4px; margin: 0 auto; flex-wrap: wrap; justify-content: center; }
  .pv-menu span { color: var(--pv-nav-text); font-size: 12px; font-weight: 700; padding: 6px 10px; border-radius: 7px; }
  .pv-menu span.active { color: var(--pv-nav-active); background: var(--pv-nav-accent-soft); }
  .pv-pmb { background: var(--pv-pmb-bg); color: var(--pv-pmb-text); font-size: 12px; font-weight: 800; padding: 7px 14px; border-radius: 8px; white-space: nowrap; }
  .pv-login { color: var(--pv-nav-text); border: 1px solid var(--pv-nav-text-soft); font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px; white-space: nowrap; }

  .pv-footer { background: var(--pv-f-bg); border-top: 4px solid var(--pv-f-accent); color: var(--pv-f-text); padding: 26px 26px 16px; }
  .pv-footer h6 { color: var(--pv-f-head); font-weight: 800; font-size: 13px; margin-bottom: 10px; }
  .pv-footer .pv-f-brand { color: var(--pv-f-head); font-weight: 800; font-size: 14px; }
  .pv-footer p, .pv-footer li { font-size: 11.5px; line-height: 1.6; }
  .pv-footer ul { list-style: none; padding: 0; margin: 0; }
  .pv-footer i.pv-acc { color: var(--pv-f-accent); }
  .pv-footer .pv-f-bottom { border-top: 1px solid var(--pv-f-divider); margin-top: 18px; padding-top: 12px; font-size: 11px; display: flex; justify-content: space-between; gap: 8px; flex-wrap: wrap; }

  .tp-card { border: 0; border-radius: 14px; box-shadow: 0 1px 3px rgba(15,23,42,.06); }
  .tp-card .card-title { padding: 0; margin: 0; font-size: 15px; color: #0f172a; font-weight: 700; }
  .tp-card .tp-sub { font-size: 12.5px; color: #64748b; }
  .tp-preset { border: 1px solid #e2e8f0; background: #fff; border-radius: 10px; padding: 7px 12px; font-size: 12.5px; font-weight: 600; color: #334155; display: inline-flex; align-items: center; gap: 8px; transition: border-color .2s ease, background-color .2s ease; }
  .tp-preset:hover { border-color: #94a3b8; background: #f8fafc; }
  .tp-preset .sw { width: 14px; height: 14px; border-radius: 50%; border: 1px solid rgba(0,0,0,.15); }
  .tp-color { display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px 10px; }
  .tp-color input[type=color] { width: 40px; height: 34px; border: 0; padding: 0; background: transparent; cursor: pointer; }
  .tp-color input[type=text] { border: 0; background: transparent; font-family: monospace; font-weight: 700; padding: 0; box-shadow: none; }
  .tp-logo-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 14px; display: flex; gap: 14px; align-items: center; }
  .tp-logo-box img { width: 64px; height: 64px; object-fit: contain; background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 6px; }

  .tp-layout-list { list-style: none; padding: 0; margin: 0; }
  .tp-layout-item { display: flex; align-items: center; gap: 12px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px; margin-bottom: 8px; transition: border-color .2s ease, opacity .2s ease, box-shadow .2s ease; }
  .tp-layout-item.is-hidden { opacity: .55; background: #f8fafc; }
  .tp-layout-item.dragging { box-shadow: 0 10px 24px rgba(15,23,42,.15); border-color: #046b26; }
  .tp-handle { cursor: grab; color: #94a3b8; font-size: 18px; }
  .tp-num { width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #334155; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .tp-sec-icon { width: 34px; height: 34px; border-radius: 9px; background: #ecf8f0; color: #046b26; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .tp-move { width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
  @media (max-width: 767.98px) {
    .tp-tabs { grid-template-columns: 1fr; }
    .pv-menu { display: none; }
  }
</style>

<div class="pagetitle">
    <h1>Warna Header, Footer & Tata Letak Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Tampilan & Navigasi</li>
            <li class="breadcrumb-item active">Warna Header, Footer & Layout</li>
        </ol>
    </nav>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Periksa kembali input Anda:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="tp-tabs mb-4" role="tablist">
    <button type="button" class="tp-tab {{ $activeTab === 'header' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-header" role="tab">
        <i class="bi bi-window-desktop"></i>
        <span><strong>Header & Navbar</strong><small>Preview & pengaturan navbar atas</small></span>
    </button>
    <button type="button" class="tp-tab {{ $activeTab === 'footer' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-footer" role="tab">
        <i class="bi bi-layout-sidebar-inset-reverse"></i>
        <span><strong>Footer Website</strong><small>Preview, warna & konten bawah</small></span>
    </button>
    <button type="button" class="tp-tab {{ $activeTab === 'layout' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-layout" role="tab">
        <i class="bi bi-arrow-down-up"></i>
        <span><strong>Tata Letak Beranda</strong><small>Urutan & visibilitas {{ count($catalog) }} section</small></span>
    </button>
</div>

<div class="tab-content">

    {{-- ══════════════ TAB HEADER ══════════════ --}}
    <div class="tab-pane fade {{ $activeTab === 'header' ? 'show active' : '' }}" id="tab-header" role="tabpanel">
        <div class="tp-browser mb-4">
            <div class="tp-browser-bar">
                <div class="tp-dots"><span style="background:#ef4444"></span><span style="background:#f59e0b"></span><span style="background:#22c55e"></span></div>
                <div class="tp-url"><i class="bi bi-lock-fill me-1"></i>{{ url('/') }}</div>
                <span class="tp-live d-none d-md-inline">● LIVE PREVIEW HEADER</span>
                <a href="{{ route('homepage') }}" target="_blank" class="btn btn-sm btn-outline-light py-0"><i class="bi bi-box-arrow-up-right me-1"></i>Website</a>
            </div>
            <div class="pv-nav" id="pvHeader">
                <div class="pv-brand">
                    <img src="{{ $h->logo_url }}" alt="Logo" id="pvLogo">
                    <div>
                        <div class="pv-brand-title" id="pvJudul">{{ $h->judul }}</div>
                        <div class="pv-brand-sub" id="pvSubjudul" style="{{ empty($h->subjudul) ? 'display:none' : '' }}">{{ $h->subjudul }}</div>
                    </div>
                </div>
                <div class="pv-menu">
                    <span class="active">Beranda</span><span>Profil <i class="bi bi-chevron-down" style="font-size:9px"></i></span><span>Fakultas <i class="bi bi-chevron-down" style="font-size:9px"></i></span><span>Kemahasiswaan</span><span>Informasi</span><span>Humas</span><span>Kontak</span>
                </div>
                <span class="pv-pmb"><i class="bi bi-pencil-square me-1"></i>PMB</span>
                <span class="pv-login"><i class="bi bi-box-arrow-in-right me-1"></i>Login</span>
            </div>
        </div>

        <form action="{{ route('tampilan.update-header') }}" method="POST" enctype="multipart/form-data" id="formHeader">
            @csrf
            @method('PUT')

            <div class="card tp-card mb-4">
                <div class="card-body pt-4">
                    <div class="mb-3">
                        <h5 class="card-title"><i class="bi bi-shield-check text-warning me-2"></i>Identitas Logo & Teks Brand Header</h5>
                        <div class="tp-sub">Logo, judul utama dan subjudul yang tampil di header dan footer website.</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold small"><i class="bi bi-image me-1 text-warning"></i>Logo Brand Header</label>
                            <div class="tp-logo-box">
                                <img src="{{ $h->logo_url }}" alt="Logo" id="logoThumb">
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" id="logoInput" class="form-control form-control-sm" accept=".png,.jpg,.jpeg,.webp,.svg">
                                    <div class="form-text" style="font-size:11px">PNG, JPG, WEBP, SVG (maks. 10MB). Disarankan latar transparan.</div>
                                    @if(!empty($h->logo))
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="hapus_logo" value="1" id="hapusLogo">
                                            <label class="form-check-label small text-danger" for="hapusLogo">Kembalikan ke logo bawaan UIS</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold small" for="judul"><span class="text-primary me-1">H1</span>Judul Utama Header <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control fw-bold" value="{{ old('judul', $h->judul) }}" maxlength="80" required>
                            <div class="form-text" style="font-size:11px">Contoh: <strong>UNIVERSITAS IBNU SINA</strong> (baris atas tebal)</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold small" for="subjudul"><span class="text-primary me-1">Aa</span>Subjudul (Opsional)</label>
                            <input type="text" name="subjudul" id="subjudul" class="form-control" value="{{ old('subjudul', $h->subjudul) }}" maxlength="120" placeholder="Contoh: Kampusnya Profesional Muda">
                            <div class="form-text" style="font-size:11px">Kosongkan bila tidak ingin menampilkan baris kedua.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <div class="card tp-card h-100">
                        <div class="card-body pt-4">
                            <h5 class="card-title"><i class="bi bi-palette text-warning me-2"></i>Palet Warna Siap Pakai</h5>
                            <div class="tp-sub mb-3">Klik salah satu kombinasi untuk menerapkan warna header secara instan, lalu simpan.</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($presets as $key => $preset)
                                    <button type="button" class="tp-preset" data-preset="{{ $key }}" data-group="header">
                                        <span class="sw" style="background: {{ $preset['header']['nav_bg'] }}"></span>{{ $preset['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card tp-card h-100">
                        <div class="card-body pt-4">
                            <h5 class="card-title"><i class="bi bi-sliders text-primary me-2"></i>Kustomisasi Warna Navbar Header</h5>
                            <div class="tp-sub mb-3">Sesuaikan kombinasi warna sesuai identitas brand kampus.</div>
                            <div class="row g-3">
                                @foreach($headerColors as $field => [$label, $hint])
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small mb-1">{{ $label }}</label>
                                        <div class="tp-color">
                                            <input type="color" value="{{ old($field, $h->$field) }}" data-color-for="{{ $field }}">
                                            <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control form-control-sm" value="{{ old($field, $h->$field) }}" maxlength="7" data-color-text>
                                        </div>
                                        <div class="form-text" style="font-size:11px">{{ $hint }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
                <button type="submit" form="resetHeader" class="btn btn-outline-secondary" onclick="return confirm('Kembalikan warna & teks header ke bawaan?')">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Default
                </button>
                <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Simpan Pengaturan Header</button>
            </div>
        </form>
    </div>

    {{-- ══════════════ TAB FOOTER ══════════════ --}}
    <div class="tab-pane fade {{ $activeTab === 'footer' ? 'show active' : '' }}" id="tab-footer" role="tabpanel">
        <div class="tp-browser mb-4">
            <div class="tp-browser-bar">
                <div class="tp-dots"><span style="background:#ef4444"></span><span style="background:#f59e0b"></span><span style="background:#22c55e"></span></div>
                <div class="tp-url"><i class="bi bi-lock-fill me-1"></i>{{ url('/') }}#footer</div>
                <span class="tp-live d-none d-md-inline">● LIVE PREVIEW FOOTER</span>
            </div>
            <div class="pv-footer" id="pvFooter">
                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $h->logo_url }}" alt="Logo" style="height:34px;width:auto;object-fit:contain">
                            <span class="pv-f-brand">{{ $h->judul }}</span>
                        </div>
                        <p class="mb-0" id="pvFDesc">{{ $f->deskripsi }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6>Navigasi</h6>
                        <ul><li>› Beranda</li><li>› Program Studi</li><li>› Berita Kampus</li><li>› Hubungi Kami</li></ul>
                    </div>
                    <div class="col-6 col-md-4">
                        <h6>Kontak Kampus</h6>
                        <ul>
                            <li><i class="bi bi-geo-alt pv-acc me-1"></i>{{ \Illuminate\Support\Str::limit($contact->alamat ?? 'Batam, Kepulauan Riau', 42) }}</li>
                            <li><i class="bi bi-envelope pv-acc me-1"></i>{{ $contact->email ?? 'info@uis.ac.id' }}</li>
                            <li><i class="bi bi-clock pv-acc me-1"></i><span id="pvFJam">{{ $f->jam_operasional }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="pv-f-bottom">
                    <span>© {{ date('Y') }} <span id="pvFCopy">{{ $f->copyright }}</span></span>
                    <span>Kebijakan Privasi · Syarat & Ketentuan · <span style="color:var(--pv-f-accent)">Portal Admin</span></span>
                </div>
            </div>
        </div>

        <form action="{{ route('tampilan.update-footer') }}" method="POST" id="formFooter">
            @csrf
            @method('PUT')
            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <div class="card tp-card mb-4">
                        <div class="card-body pt-4">
                            <h5 class="card-title"><i class="bi bi-palette text-warning me-2"></i>Palet Warna Siap Pakai</h5>
                            <div class="tp-sub mb-3">Terapkan kombinasi warna footer secara instan.</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($presets as $key => $preset)
                                    <button type="button" class="tp-preset" data-preset="{{ $key }}" data-group="footer">
                                        <span class="sw" style="background: {{ $preset['footer']['footer_bg'] }}"></span>{{ $preset['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card tp-card">
                        <div class="card-body pt-4">
                            <h5 class="card-title"><i class="bi bi-sliders text-primary me-2"></i>Kustomisasi Warna Footer</h5>
                            <div class="row g-3 mt-1">
                                @foreach($footerColors as $field => [$label, $hint])
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small mb-1">{{ $label }}</label>
                                        <div class="tp-color">
                                            <input type="color" value="{{ old($field, $f->$field) }}" data-color-for="{{ $field }}">
                                            <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control form-control-sm" value="{{ old($field, $f->$field) }}" maxlength="7" data-color-text>
                                        </div>
                                        <div class="form-text" style="font-size:11px">{{ $hint }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card tp-card h-100">
                        <div class="card-body pt-4">
                            <h5 class="card-title"><i class="bi bi-card-text text-success me-2"></i>Konten Teks Footer</h5>
                            <div class="tp-sub mb-3">Alamat, telepon & email mengikuti menu <a href="{{ route('contact.index') }}">Kontak</a>.</div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-semibold small">Deskripsi Singkat Kampus</label>
                                <textarea name="deskripsi" id="footer_deskripsi" rows="5" class="form-control" maxlength="600">{{ old('deskripsi', $f->deskripsi) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="jam_operasional" class="form-label fw-semibold small">Jam Operasional</label>
                                <input type="text" name="jam_operasional" id="jam_operasional" class="form-control" maxlength="120" value="{{ old('jam_operasional', $f->jam_operasional) }}">
                            </div>
                            <div class="mb-3">
                                <label for="copyright" class="form-label fw-semibold small">Teks Hak Cipta</label>
                                <div class="input-group">
                                    <span class="input-group-text">© {{ date('Y') }}</span>
                                    <input type="text" name="copyright" id="copyright" class="form-control" maxlength="150" value="{{ old('copyright', $f->copyright) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
                <button type="submit" form="resetFooter" class="btn btn-outline-secondary" onclick="return confirm('Kembalikan pengaturan footer ke bawaan?')">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Default
                </button>
                <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Simpan Pengaturan Footer</button>
            </div>
        </form>
    </div>

    {{-- ══════════════ TAB LAYOUT ══════════════ --}}
    <div class="tab-pane fade {{ $activeTab === 'layout' ? 'show active' : '' }}" id="tab-layout" role="tabpanel">
        <form action="{{ route('tampilan.update-layout') }}" method="POST" id="formLayout">
            @csrf
            @method('PUT')
            <input type="hidden" name="urutan" id="layoutOrder" value="{{ implode(',', array_keys($tampilan->layout)) }}">

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card tp-card">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                <div>
                                    <h5 class="card-title"><i class="bi bi-arrow-down-up text-primary me-2"></i>Urutan Section Halaman Beranda</h5>
                                    <div class="tp-sub">Seret ikon <i class="bi bi-grip-vertical"></i> atau gunakan tombol panah untuk mengubah urutan. Matikan sakelar untuk menyembunyikan section.</div>
                                </div>
                                <span class="badge bg-light text-dark border" id="layoutCounter">{{ count($catalog) - $hiddenCount }} tampil · {{ $hiddenCount }} disembunyikan</span>
                            </div>

                            <ul class="tp-layout-list" id="layoutList">
                                @foreach($tampilan->layout as $key => $row)
                                    @php $meta = $catalog[$key] ?? ['label' => $key, 'icon' => 'bi-square']; @endphp
                                    <li class="tp-layout-item {{ empty($row['visible']) ? 'is-hidden' : '' }}" data-key="{{ $key }}" draggable="true">
                                        <i class="bi bi-grip-vertical tp-handle"></i>
                                        <span class="tp-num">{{ $loop->iteration }}</span>
                                        <span class="tp-sec-icon"><i class="bi {{ $meta['icon'] }}"></i></span>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-semibold text-dark" style="font-size:13.5px">{{ $meta['label'] }}</div>
                                            <div class="text-muted" style="font-size:11px">#{{ $key }}</div>
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
                </div>
                <div class="col-lg-4">
                    <div class="card tp-card">
                        <div class="card-body pt-4">
                            <h5 class="card-title mb-2"><i class="bi bi-info-circle text-success me-2"></i>Catatan</h5>
                            <ul class="small text-secondary ps-3 mb-3">
                                <li class="mb-1">Perubahan langsung diterapkan ke halaman beranda setelah disimpan, tanpa perlu memuat ulang.</li>
                                <li class="mb-1">Section yang disembunyikan tidak dihapus — isi kontennya tetap tersimpan dan dapat ditampilkan kembali kapan saja.</li>
                                <li>Isi tiap section tetap dikelola melalui menu <strong>Konten Beranda</strong> masing-masing.</li>
                            </ul>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan Tata Letak</button>
                                <a href="{{ route('homepage') }}" target="_blank" class="btn btn-outline-success"><i class="bi bi-box-arrow-up-right me-1"></i> Lihat Beranda</a>
                                <button type="submit" form="resetLayout" class="btn btn-outline-secondary" onclick="return confirm('Kembalikan urutan & visibilitas section ke bawaan?')">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Urutan Default
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Form reset (di luar form utama agar tidak bersarang) --}}
<form action="{{ route('tampilan.reset', 'header') }}" method="POST" id="resetHeader" class="d-none">@csrf</form>
<form action="{{ route('tampilan.reset', 'footer') }}" method="POST" id="resetFooter" class="d-none">@csrf</form>
<form action="{{ route('tampilan.reset', 'layout') }}" method="POST" id="resetLayout" class="d-none">@csrf</form>
@endsection

@push('scripts')
<script>
(function () {
    const presets = @json($presets);
    const isHex = (v) => /^#([0-9a-f]{3}|[0-9a-f]{6})$/i.test(v);
    const full = (v) => v.length === 4 ? '#' + [...v.slice(1)].map(c => c + c).join('') : v;
    const val = (id) => { const el = document.getElementById(id); return el && isHex(el.value.trim()) ? full(el.value.trim()) : null; };
    const isLight = (hex) => {
        const h = full(hex).slice(1);
        const r = parseInt(h.substr(0, 2), 16), g = parseInt(h.substr(2, 2), 16), b = parseInt(h.substr(4, 2), 16);
        return (0.299 * r + 0.587 * g + 0.114 * b) > 160;
    };

    // ── Tabs: perbarui query ?tab= agar posisi tab tetap saat reload
    document.querySelectorAll('.tp-tab').forEach(btn => {
        btn.addEventListener('shown.bs.tab', () => {
            document.querySelectorAll('.tp-tab').forEach(b => b.classList.toggle('active', b === btn));
            const tab = btn.dataset.bsTarget.replace('#tab-', '');
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            history.replaceState(null, '', url);
        });
    });

    // ── Live preview
    function renderPreview() {
        const hp = document.getElementById('pvHeader');
        const navBg = val('nav_bg'), navText = val('nav_text'), accent = val('nav_accent');
        if (hp && navBg && navText && accent) {
            hp.style.setProperty('--pv-nav-bg', navBg);
            hp.style.setProperty('--pv-nav-text', navText);
            hp.style.setProperty('--pv-nav-text-soft', navText + '59');
            hp.style.setProperty('--pv-nav-accent', accent);
            hp.style.setProperty('--pv-nav-accent-soft', accent + '2e');
            hp.style.setProperty('--pv-nav-active', isLight(navBg) ? navText : accent);
            hp.style.setProperty('--pv-pmb-bg', val('pmb_bg') || '#ffffff');
            hp.style.setProperty('--pv-pmb-text', val('pmb_text') || '#046b26');
        }
        const fp = document.getElementById('pvFooter');
        const fBg = val('footer_bg'), fText = val('footer_text'), fHead = val('footer_heading'), fAcc = val('footer_accent');
        if (fp && fBg && fText && fHead && fAcc) {
            fp.style.setProperty('--pv-f-bg', fBg);
            fp.style.setProperty('--pv-f-text', fText);
            fp.style.setProperty('--pv-f-head', fHead);
            fp.style.setProperty('--pv-f-accent', fAcc);
            fp.style.setProperty('--pv-f-divider', fText + '33');
        }
    }

    function setColor(field, hex) {
        const text = document.getElementById(field);
        const picker = document.querySelector('[data-color-for="' + field + '"]');
        if (text) text.value = hex;
        if (picker) picker.value = full(hex);
    }

    document.querySelectorAll('[data-color-for]').forEach(picker => {
        picker.addEventListener('input', () => { setColor(picker.dataset.colorFor, picker.value); renderPreview(); });
    });
    document.querySelectorAll('[data-color-text]').forEach(text => {
        text.addEventListener('input', () => {
            const v = text.value.trim();
            if (isHex(v)) {
                const picker = document.querySelector('[data-color-for="' + text.id + '"]');
                if (picker) picker.value = full(v);
            }
            renderPreview();
        });
    });

    document.querySelectorAll('.tp-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const p = presets[btn.dataset.preset];
            if (!p) return;
            Object.entries(p[btn.dataset.group]).forEach(([field, hex]) => setColor(field, hex));
            renderPreview();
        });
    });

    // Teks brand & footer
    const bindText = (inputId, targetId, hideWhenEmpty) => {
        const input = document.getElementById(inputId), target = document.getElementById(targetId);
        if (!input || !target) return;
        input.addEventListener('input', () => {
            target.textContent = input.value;
            if (hideWhenEmpty) target.style.display = input.value.trim() ? '' : 'none';
        });
    };
    bindText('judul', 'pvJudul');
    bindText('subjudul', 'pvSubjudul', true);
    bindText('footer_deskripsi', 'pvFDesc');
    bindText('jam_operasional', 'pvFJam');
    bindText('copyright', 'pvFCopy');

    const logoInput = document.getElementById('logoInput');
    if (logoInput) {
        logoInput.addEventListener('change', () => {
            const file = logoInput.files && logoInput.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            document.getElementById('pvLogo').src = url;
            document.getElementById('logoThumb').src = url;
        });
    }

    renderPreview();

    // ── Tata letak: drag & drop + tombol naik/turun
    const list = document.getElementById('layoutList');
    const orderInput = document.getElementById('layoutOrder');
    const counter = document.getElementById('layoutCounter');

    function refreshLayout() {
        const items = [...list.querySelectorAll('.tp-layout-item')];
        items.forEach((li, i) => {
            li.querySelector('.tp-num').textContent = i + 1;
            li.classList.toggle('is-hidden', !li.querySelector('.tp-visible').checked);
        });
        orderInput.value = items.map(li => li.dataset.key).join(',');
        const shown = items.filter(li => li.querySelector('.tp-visible').checked).length;
        counter.textContent = shown + ' tampil · ' + (items.length - shown) + ' disembunyikan';
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
        refreshLayout();
    });
    list.addEventListener('change', (e) => { if (e.target.classList.contains('tp-visible')) refreshLayout(); });

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
        refreshLayout();
    });
    list.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (!dragged) return;
        const after = [...list.querySelectorAll('.tp-layout-item:not(.dragging)')].find(li => {
            const box = li.getBoundingClientRect();
            return e.clientY < box.top + box.height / 2;
        });
        if (after) list.insertBefore(dragged, after); else list.appendChild(dragged);
    });

    refreshLayout();
})();
</script>
@endpush

