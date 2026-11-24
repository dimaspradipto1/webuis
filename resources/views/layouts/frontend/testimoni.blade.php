@extends('layouts.frontend.template')

@section('title', 'Kisah Sukses & Testimoni Alumni — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Baca ulasan, pengalaman, dan jejak karier alumni, mahasiswa, serta mitra industri Universitas Ibnu Sina (UIS) Batam.')
@section('meta_keywords', 'testimoni alumni uis, review universitas ibnu sina, jejak karir alumni batam, ulasan lulusan uis, kampus profesional muda')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'testimoni',
    'heroClass' => 'about-hero'
])

<!-- ═══════════════════════════════════════════════
     RATING ANALYTICS & SUMMARY SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <!-- Left: Big Score Box -->
      <div class="col-lg-4" data-aos="fade-right">
        <div class="rating-score-box">
          <div class="rating-big-num">{{ number_format($avgScore, 1) }}</div>
          <div class="d-flex justify-content-center gap-1 fs-5 mb-2" style="color: #FED802;">
            @for($i = 1; $i <= 5; $i++)
              <i class="bi bi-star{{ $i <= round($avgScore) ? '-fill' : '' }}"></i>
            @endfor
          </div>
          <h4 class="fw-bold text-white mb-1" style="font-size: 18px;">Penilaian Keseluruhan</h4>
          <p class="text-white-50 small mb-0">Berdasarkan {{ $totalCount }} ulasan terverifikasi civitas & alumni Universitas Ibnu Sina</p>
        </div>
      </div>

      <!-- Right: Rating Breakdown Bars -->
      <div class="col-lg-8" data-aos="fade-left">
        <div class="rating-bar-wrap">
          <h3 class="fw-bold text-dark mb-3" style="font-size: 18px;">
            <i class="bi bi-bar-chart-line-fill me-2" style="color:#046B26;"></i> Distribusi Penilaian Bintang
          </h3>

          @foreach([5, 4, 3, 2, 1] as $star)
            <div class="star-progress-row">
              <div class="star-label">
                <span>{{ $star }}</span>
                <i class="bi bi-star-fill text-warning" style="font-size: 12px;"></i>
              </div>
              <div class="progress-custom">
                <div class="progress-bar-uis" style="width: {{ $ratingPercentages[$star] ?? 0 }}%;"></div>
              </div>
              <div class="star-pct">{{ $ratingCounts[$star] ?? 0 }} <small class="text-muted">({{ $ratingPercentages[$star] ?? 0 }}%)</small></div>
            </div>
          @endforeach

          <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top" style="border-color: #f2e9f7 !important;">
            <span class="text-muted small">Kategori terdaftar: <strong>{{ count($categories) }} Segmen Civitas</strong></span>
            <span class="badge" style="background:#046B26; color:#fff;">100% Ulasan Terverifikasi</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     TESTIMONIALS LIST & FILTER SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container">
    
    <!-- Filter & Search Bar -->
    <div class="dash-card mb-5" data-aos="fade-up" style="background: #faf7fc; border: 1px solid #eddff5; border-radius: 18px; padding: 20px 24px;">
      <form action="{{ route('homepage.testimoni') }}" method="GET" class="row g-3 align-items-center">
        
        <!-- Search Input -->
        <div class="col-md-5">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0" style="border-color: #d8c2e6;"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="q" class="form-control border-start-0" placeholder="Cari nama alumni, profesi, atau kata kunci..." value="{{ $search }}" style="border-color: #d8c2e6;">
          </div>
        </div>

        <!-- Filter Kategori -->
        <div class="col-md-3">
          <select name="kategori" class="form-select" style="border-color: #d8c2e6;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ $selectedKategori === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
        </div>

        <!-- Filter Rating -->
        <div class="col-md-2">
          <select name="rating" class="form-select" style="border-color: #d8c2e6;">
            <option value="">Semua Rating</option>
            <option value="5" {{ $selectedRating == 5 ? 'selected' : '' }}>★ 5 Bintang</option>
            <option value="4" {{ $selectedRating == 4 ? 'selected' : '' }}>★ 4 Bintang</option>
            <option value="3" {{ $selectedRating == 3 ? 'selected' : '' }}>★ 3 Bintang</option>
            <option value="2" {{ $selectedRating == 2 ? 'selected' : '' }}>★ 2 Bintang</option>
            <option value="1" {{ $selectedRating == 1 ? 'selected' : '' }}>★ 1 Bintang</option>
          </select>
        </div>

        <!-- Submit & Reset -->
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary w-100 fw-bold" style="background:#046B26; border-color:#046B26;">
            Filter
          </button>
          @if(!empty($search) || !empty($selectedKategori) || !empty($selectedRating))
            <a href="{{ route('homepage.testimoni') }}" class="btn btn-outline-secondary" title="Reset Filter">
              <i class="bi bi-arrow-counterclockwise"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Testimonial Cards Grid -->
    <div class="row g-4 mb-5">
      @forelse($testimonials as $index => $testi)
        @php
          $initials = '';
          $words = explode(' ', $testi->nama);
          foreach ($words as $w) {
              $initials .= strtoupper(substr($w, 0, 1));
          }
          $initials = substr($initials, 0, 2);
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ (($index % 3) + 1) * 80 }}">
          <div class="testi-card h-100 shadow-sm" style="background: #ffffff; border: 1.5px solid #f0e6f5; border-radius: 20px; padding: 28px 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="testi-stars m-0" style="color: #FED802; font-size: 15px; display: flex; gap: 3px;">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $testi->bintang ? '-fill' : '' }}"></i>
                  @endfor
                </div>
                <span class="badge" style="background: #f5edf8; color: #046B26; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 8px;">
                  {{ $testi->kategori ?? 'Alumni' }}
                </span>
              </div>
              <p class="testi-text mb-4" style="font-size: 14px; line-height: 1.6; color: #333333; font-style: italic;">"{{ $testi->pesan }}"</p>
            </div>
            <div class="testi-author pt-3 border-top d-flex align-items-center gap-3" style="border-color: #f7effa !important;">
              <div class="testi-avatar flex-shrink-0" style="width: 44px; height: 44px; border-radius: 50%; background: #046B26; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">{{ $initials ?: 'AL' }}</div>
              <div>
                <div class="testi-name text-dark fw-bold" style="font-size: 14px; line-height: 1.3;">{{ $testi->nama }}</div>
                <div class="testi-role text-muted small" style="font-size: 12px;">{{ $testi->pekerjaan ?? 'Alumni Universitas Ibnu Sina' }}</div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <div class="py-5" style="background: #faf7fc; border-radius: 20px;">
            <i class="bi bi-chat-square-text text-muted" style="font-size: 48px;"></i>
            <h5 class="fw-bold mt-3 text-dark">Tidak Ada Testimoni yang Sesuai</h5>
            <p class="text-muted small">Coba ubah kata kunci pencarian atau reset filter untuk menampilkan semua ulasan.</p>
            <a href="{{ route('homepage.testimoni') }}" class="btn btn-sm btn-outline-primary" style="color:#046B26; border-color:#046B26;">Reset Filter</a>
          </div>
        </div>
      @endforelse
    </div>

    <!-- PAGINATION (10 DATA PER HALAMAN) -->
    <div class="d-flex justify-content-center mt-4">
      {{ $testimonials->links('pagination::bootstrap-5') }}
    </div>

  </div>
</section>

@endsection
