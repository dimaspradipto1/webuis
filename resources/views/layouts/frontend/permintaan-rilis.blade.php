@extends('layouts.frontend.template')

@section('title', ($setting->judul_hero ?? 'Permintaan Rilis') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Panduan dan layanan pengajuan rilis berita resmi Universitas Ibnu Sina (UIS) Batam. Ketentuan 5W+1H, minimal 250 kata, foto resolusi tinggi, dan alur publikasi.')
@section('meta_keywords', 'permintaan rilis uis, siaran pers uis, berita humas uis, panduan rilis uis batam')

@section('content')
<style>
  /* ═══════════════════════════════════════════════
     STYLING HALAMAN PERMINTAAN RILIS
  ═══════════════════════════════════════════════ */
  .permintaan-rilis-section {
    background-color: #f8fafc;
    padding: 60px 0 90px 0;
  }

  .divider-line-gold {
    width: 60px;
    height: 4px;
    background: #fab005;
    border-radius: 4px;
    margin: 14px auto 24px auto;
  }

  /* Kartu Aksi Cepat / CTA */
  .cta-action-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 28px 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s ease;
  }
  .cta-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(4, 107, 38, 0.1);
    border-color: #0b6828;
  }
  .cta-icon-badge {
    width: 58px;
    height: 58px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 18px;
  }

  /* Kotak Ketentuan Berita */
  .rule-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 24px;
    height: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
  }
  .rule-card:hover {
    border-color: #0b6828;
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(11, 104, 40, 0.08);
  }
  .rule-number-badge {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #e8f5e9;
    color: #0b6828;
    font-weight: 800;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    flex-shrink: 0;
  }
  .rule-title {
    font-weight: 700;
    color: #1e293b;
    font-size: 17px;
    margin-bottom: 10px;
    line-height: 1.35;
  }
  .rule-desc {
    color: #64748b;
    font-size: 14px;
    line-height: 1.65;
    margin-bottom: 0;
  }

  /* Alur Step Flow */
  .step-flow-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 24px 20px;
    text-align: center;
    position: relative;
    height: 100%;
    transition: all 0.3s ease;
  }
  .step-flow-card:hover {
    transform: translateY(-4px);
    border-color: #0b6828;
    box-shadow: 0 10px 24px rgba(11, 104, 40, 0.08);
  }
  .step-num-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #0b6828;
    color: #ffffff;
    font-weight: 800;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px auto;
    box-shadow: 0 6px 14px rgba(11, 104, 40, 0.25);
  }

  /* Info Note Box */
  .note-alert-box {
    background: #f0fdf4;
    border-left: 5px solid #0b6828;
    border-radius: 0 12px 12px 0;
    padding: 20px 24px;
  }
</style>

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="faq-hero">
  <div class="container">
    <div class="faq-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="faq-hero-title">
        {{ $setting->judul_hero ?? 'Permintaan Rilis' }} <em>(Humas)</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.humas') }}">Humas</a>
        <span>/</span>
        <span class="active">{{ $setting->judul_hero ?? 'Permintaan Rilis' }}</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     KONTEN UTAMA PERMINTAAN RILIS
═══════════════════════════════════════════════ -->
<section class="permintaan-rilis-section">
  <div class="container">
    
    {{-- Header Judul & Deskripsi --}}
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto mb-3">
        {{ $setting->badge_label ?? 'LAYANAN PUBLIKASI & SIARAN PERS' }}
      </div>
      
      <h2 class="fw-bold mb-0" style="color: #1e3a29; font-size: 32px; letter-spacing: -0.5px; font-family: 'Plus Jakarta Sans', sans-serif;">
        {{ $setting->judul_seksi ?? 'Ketentuan Permintaan Rilis Berita' }}
      </h2>
      
      <div class="divider-line-gold"></div>

      <div class="text-muted mx-auto mb-0" style="max-width: 860px; font-size: 15px; line-height: 1.8;">
        {!! $setting->deskripsi_seksi ?? 'Layanan ini disediakan oleh Biro Humas Universitas Ibnu Sina (UIS) guna memfasilitasi sivitas akademika dalam mengajukan rilis berita kegiatan atau siaran pers untuk dipublikasikan pada portal berita resmi uis.ac.id dan media massa mitra universitas.' !!}
      </div>
    </div>

    {{-- KARTU AKSI CEPAT / CTA --}}
    <div class="row g-4 mb-5" data-aos="fade-up">
      {{-- CTA 1: Formulir Daring Google Form --}}
      <div class="col-lg-4 col-md-6 col-12">
        <div class="cta-action-card">
          <div>
            <div class="cta-icon-badge bg-success bg-opacity-10 text-success">
              <i class="bi bi-ui-checks"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2">Formulir Pengajuan Daring</h5>
            <p class="text-muted small mb-4" style="line-height: 1.6;">
              Isi data kegiatan, draf naskah, dan unggah tautan dokumentasi foto melalui formulir daring resmi Biro Humas UIS.
            </p>
          </div>
          <div>
            @php
              $rilisForm = trim($setting->link_form ?? '');
              $isInvalidRilisForm = in_array(rtrim($rilisForm, '/'), ['https://forms.gle', 'http://forms.gle', 'forms.gle', ''], true);
              $waRilisApplyText = rawurlencode('Halo Tim Humas UIS, saya ingin mengajukan permohonan penerbitan rilis berita / siaran pers.');
            @endphp
            @if(!$isInvalidRilisForm)
              <a href="{{ $rilisForm }}" target="_blank" rel="noopener noreferrer" class="btn btn-success w-100 fw-bold py-2 shadow-sm" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
                <i class="bi bi-box-arrow-up-right me-1"></i> Isi Formulir Rilis
              </a>
            @else
              <a href="https://wa.me/{{ $cleanWa }}?text={{ $waRilisApplyText }}" target="_blank" rel="noopener noreferrer" class="btn btn-success w-100 fw-bold py-2 shadow-sm" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
                <i class="bi bi-whatsapp me-1"></i> Ajukan via WhatsApp
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- CTA 2: Kirim via WhatsApp Redaksi --}}
      <div class="col-lg-4 col-md-6 col-12">
        <div class="cta-action-card">
          <div>
            <div class="cta-icon-badge bg-primary bg-opacity-10 text-primary">
              <i class="bi bi-whatsapp" style="color: #25d366;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2">Kirim via WhatsApp Redaksi</h5>
            <p class="text-muted small mb-4" style="line-height: 1.6;">
              Konsultasikan naskah atau kirimkan siaran pers langsung ke nomor layanan WhatsApp resmi Tim Humas UIS.
            </p>
          </div>
          <div>
            @php
              $waTarget = !empty($cleanWa) ? $cleanWa : '6281234567890';
              $waMessage = rawurlencode('Halo Tim Humas UIS, saya ingin mengajukan draf berita/siaran pers acara untuk dipublikasikan.');
            @endphp
            <a href="https://wa.me/{{ $waTarget }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success w-100 fw-bold py-2" style="border-radius: 8px; color: #0b6828; border-color: #0b6828;">
              <i class="bi bi-chat-dots-fill me-1"></i> Chat WhatsApp Humas
            </a>
          </div>
        </div>
      </div>

      {{-- CTA 3: Unduh Format / File SOP Panduan --}}
      <div class="col-lg-4 col-md-12 col-12">
        <div class="cta-action-card">
          <div>
            <div class="cta-icon-badge bg-warning bg-opacity-10 text-warning">
              <i class="bi bi-file-earmark-arrow-down-fill" style="color: #d97706;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2">Pedoman & Format Berita</h5>
            <p class="text-muted small mb-4" style="line-height: 1.6;">
              Unduh panduan penulisan naskah siaran pers, struktur piramida terbalik, dan lembar permohonan publikasi.
            </p>
          </div>
          <div>
            @if(!empty($setting->file_sop))
              <a href="{{ asset('storage/' . $setting->file_sop) }}" target="_blank" class="btn btn-outline-dark w-100 fw-bold py-2" style="border-radius: 8px;">
                <i class="bi bi-download me-1"></i> Unduh File Panduan
              </a>
            @elseif($item && $item->file_path)
              <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-outline-dark w-100 fw-bold py-2" style="border-radius: 8px;">
                <i class="bi bi-download me-1"></i> Unduh File Panduan
              </a>
            @else
              <a href="#ketentuan-naskah" class="btn btn-outline-secondary w-100 fw-bold py-2" style="border-radius: 8px;">
                <i class="bi bi-arrow-down-circle me-1"></i> Baca Ketentuan di Bawah
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         BAGIAN 1: KETENTUAN PENULISAN BERITA (Sesuai UIS)
    ═══════════════════════════════════════════════ --}}
    <div id="ketentuan-naskah" class="mb-5" data-aos="fade-up">
      <div class="d-flex align-items-center gap-3 mb-4">
        <div class="p-2 rounded-3 bg-success text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #0b6828 !important;">
          <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <div>
          <h4 class="fw-bold text-dark mb-1">1. Ketentuan Penulisan Naskah Berita</h4>
          <p class="text-muted small mb-0">Standar mutu jurnalisme dan tata kelola siaran pers resmi universitas.</p>
        </div>
      </div>

      <div class="row g-3">
        {{-- Poin 1 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">1</div>
            <div class="rule-title">Panjang Naskah & Paragraf</div>
            <p class="rule-desc">
              Berita yang dikirimkan harus berjumlah <strong>minimal {{ $setting->min_kata ?? 250 }} kata</strong> dan terbagi menjadi <strong>minimal {{ $setting->min_paragraf ?? 4 }} paragraf</strong> agar informasi tersampaikan komprehensif.
            </p>
          </div>
        </div>

        {{-- Poin 2 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">2</div>
            <div class="rule-title">Formula 5W + 1H</div>
            <p class="rule-desc">
              Paragraf pertama (lead berita) memuat unsur <strong>4W</strong> (Apa, Siapa, Kapan, Di mana), dilanjutkan <strong>1W + 1H</strong> (Mengapa dan Bagaimana) pada paragraf penjelas berikutnya.
            </p>
          </div>
        </div>

        {{-- Poin 3 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">3</div>
            <div class="rule-title">Tujuan & Citra Institusi</div>
            <p class="rule-desc">
              Informasi yang disampaikan harus berorientasi pada <strong>peningkatan reputasi institusi</strong> UIS serta bernilai informatif bagi publik internal civitas akademika maupun khalayak eksternal.
            </p>
          </div>
        </div>

        {{-- Poin 4 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">4</div>
            <div class="rule-title">Bahasa Baku & Kalimat Aktif</div>
            <p class="rule-desc">
              Menggunakan kaidah Bahasa Indonesia yang baik dan benar (EYD), lugas, serta menyertakan <strong>kutipan pernyataan langsung</strong> dari narasumber atau pimpinan acara.
            </p>
          </div>
        </div>

        {{-- Poin 5 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">5</div>
            <div class="rule-title">Judul SPO & Penjelasan Singkatan</div>
            <p class="rule-desc">
              Judul berita harus memuat unsur Subjek, Predikat, dan Objek (SPO). Setiap singkatan wajib dijelaskan kepanjangannya pada penyebutan pertama (contoh: <em>UIS dijabarkan Universitas Ibnu Sina</em>).
            </p>
          </div>
        </div>

        {{-- Poin 6 --}}
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="rule-number-badge">6</div>
            <div class="rule-title">Orisinalitas & Inisial Penulis</div>
            <p class="rule-desc">
              Berita bersifat aktual dan bebas plagiarisme. Di akhir kalimat penutup berita, wajib menyertakan keterangan atau <strong>inisial penulis/kontributor</strong> (contoh: <em>hms/nama_penulis</em>).
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         BAGIAN 2: KETENTUAN FOTO & DOKUMENTASI PENDUKUNG
    ═══════════════════════════════════════════════ --}}
    <div class="mb-5" data-aos="fade-up">
      <div class="d-flex align-items-center gap-3 mb-4">
        <div class="p-2 rounded-3 bg-success text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #0b6828 !important;">
          <i class="bi bi-camera-fill fs-5"></i>
        </div>
        <div>
          <h4 class="fw-bold text-dark mb-1">2. Ketentuan Foto & Dokumentasi Pendukung</h4>
          <p class="text-muted small mb-0">Standar visual dan dokumentasi kegiatan untuk publikasi digital.</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="p-2 rounded-circle bg-light text-success fs-4">
                <i class="bi bi-file-earmark-image"></i>
              </div>
              <h6 class="fw-bold text-dark mb-0">Format & Resolusi</h6>
            </div>
            <p class="rule-desc">
              Foto harus dalam format <strong>JPG, JPEG, atau PNG</strong> dengan resolusi tinggi (minimal ukuran file <strong>1 MB</strong> per foto) agar gambar tidak pecah saat ditayangkan di portal web.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
          <div class="rule-card">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="p-2 rounded-circle bg-light text-success fs-4">
                <i class="bi bi-aspect-ratio"></i>
              </div>
              <h6 class="fw-bold text-dark mb-0">Orientasi Landscape</h6>
            </div>
            <p class="rule-desc">
              Dokumentasi wajib berorientasi <strong>Landscape (Mendatar)</strong>. Foto vertikal/portrait hanya diperkenankan sebagai foto pendukung sekunder.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-12 col-12">
          <div class="rule-card">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="p-2 rounded-circle bg-light text-success fs-4">
                <i class="bi bi-award"></i>
              </div>
              <h6 class="fw-bold text-dark mb-0">Nilai Estetika & Relevansi</h6>
            </div>
            <p class="rule-desc">
              Foto harus relevan dengan substansi berita (bukan foto swafoto/selfie), pencahayaan proporsional, serta menggambarkan momen penting kegiatan/acara secara profesional.
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         BAGIAN 3: ALUR & PROSEDUR PENGAJUAN RILIS
    ═══════════════════════════════════════════════ --}}
    <div class="mb-5" data-aos="fade-up">
      <div class="d-flex align-items-center gap-3 mb-4">
        <div class="p-2 rounded-3 bg-success text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #0b6828 !important;">
          <i class="bi bi-diagram-3-fill fs-5"></i>
        </div>
        <div>
          <h4 class="fw-bold text-dark mb-1">3. Alur & Prosedur Pengajuan Rilis</h4>
          <p class="text-muted small mb-0">Tahapan proses dari pengajuan draf hingga penayangan berita resmi.</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-lg-3 col-md-6 col-12">
          <div class="step-flow-card">
            <div class="step-num-circle">1</div>
            <h6 class="fw-bold text-dark mb-2">Penyusunan Draf</h6>
            <p class="text-muted small mb-0">
              Unit/panitia menyusun naskah berita sesuai kaidah 5W+1H (min. 250 kata) dan menyiapkan 2-4 foto landscape.
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
          <div class="step-flow-card">
            <div class="step-num-circle">2</div>
            <h6 class="fw-bold text-dark mb-2">Pengiriman Berkas</h6>
            <p class="text-muted small mb-0">
              Kirimkan draf melalui Formulir Daring (Google Form) atau via WhatsApp resmi Tim Redaksi Humas UIS.
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
          <div class="step-flow-card">
            <div class="step-num-circle">3</div>
            <h6 class="fw-bold text-dark mb-2">Kurasi & Editing</h6>
            <p class="text-muted small mb-0">
              Tim redaksi Biro Humas mereview kebenaran fakta, menyelaraskan gaya bahasa, dan memproses tata letak foto.
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
          <div class="step-flow-card">
            <div class="step-num-circle">4</div>
            <h6 class="fw-bold text-dark mb-2">Publikasi Resmi</h6>
            <p class="text-muted small mb-0">
              Berita tayang di portal uis.ac.id, kanal media sosial, dan diteruskan ke jejaring media massa mitra.
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- CATATAN PENTING & KONTAK BANTUAN --}}
    <div class="note-alert-box shadow-sm mb-4" data-aos="fade-up">
      <div class="d-flex align-items-start gap-3">
        <i class="bi bi-info-circle-fill fs-3 text-success"></i>
        <div>
          <h6 class="fw-bold text-dark mb-1">Catatan Redaksi Humas:</h6>
          <div class="mb-0 text-muted small" style="line-height: 1.7;">
            {!! $setting->catatan_tambahan ?? 'Pastikan naskah telah disetujui oleh pimpinan unit/fakultas/panitia sebelum dikirimkan ke Biro Humas UIS. Berita yang memenuhi seluruh ketentuan di atas akan diprioritaskan untuk diterbitkan dalam waktu 1x24 jam kerja.' !!}
          </div>
        </div>
      </div>
    </div>

    {{-- KOTAK INFORMASI KONTAK HUMAS --}}
    <div class="p-4 bg-white rounded-4 border shadow-sm" data-aos="fade-up">
      <div class="row align-items-center g-3">
        <div class="col-lg-8 col-12">
          <h6 class="fw-bold text-dark mb-1">Butuh bantuan atau koordinasi peliputan langsung?</h6>
          <p class="text-muted small mb-0">
            Hubungi Biro Humas & Protokoler Universitas Ibnu Sina:
            <strong class="text-dark ms-1"><i class="bi bi-envelope me-1"></i>{{ $setting->email_tujuan ?? 'info@uis.ac.id' }}</strong>
            <span class="mx-2">•</span>
            <strong class="text-dark"><i class="bi bi-telephone me-1"></i>{{ $setting->no_wa ?? '07784083113' }}</strong>
          </p>
        </div>
        <div class="col-lg-4 col-12 text-lg-end">
          <a href="{{ route('homepage.kontak') }}" class="btn btn-outline-success fw-bold px-4 py-2" style="border-radius: 8px;">
            <i class="bi bi-geo-alt-fill me-1"></i> Kontak & Lokasi Kantor
          </a>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
