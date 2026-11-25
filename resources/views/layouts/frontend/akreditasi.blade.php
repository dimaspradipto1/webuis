@extends('layouts.frontend.template')

@section('title', 'Sertifikat Akreditasi — Universitas Ibnu Sina')
@section('meta_description', 'Informasi resmi status akreditasi Universitas Ibnu Sina (UIS), Fakultas, dan seluruh Program Studi oleh BAN-PT dan Lembaga Akreditasi Mandiri (LAM).')

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'akreditasi',
    'heroClass' => 'akreditasi-hero',
    'defaultTitle' => 'Sertifikat Akreditasi',
    'defaultSubtitle' => 'Penjaminan mutu pendidikan tinggi dan legalitas akreditasi resmi Universitas Ibnu Sina, Fakultas, dan seluruh Program Studi.',
    'defaultActive' => 'Akreditasi'
])

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" style="background-color: #f7faf7;">
  <div class="container">

    {{-- SECTION 1: SPOTLIGHT AKREDITASI INSTITUSI / UNIVERSITAS IBNU SINA --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-11 col-xl-10">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-white position-relative" style="background: linear-gradient(135deg, #033c16 0%, #046B26 60%, #024719 100%); border: 2px solid rgba(254, 216, 2, 0.4) !important;">
          
          {{-- Decorative watermark background --}}
          <div class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2 d-none d-md-block" style="pointer-events: none;">
            <i class="bi bi-shield-fill-check" style="font-size: 260px; color: #FED802;"></i>
          </div>

          <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center g-4">
              
              {{-- Badge Lambang Akreditasi --}}
              <div class="col-md-4 text-center">
                <div class="d-inline-flex flex-column align-items-center justify-content-center p-4 rounded-4 shadow" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(254, 216, 2, 0.3); min-width: 200px;">
                  <div class="rounded-circle p-3 mb-2 d-flex align-items-center justify-content-center shadow-sm" style="background: #FED802; width: 72px; height: 72px;">
                    <i class="bi bi-patch-check-fill fs-1" style="color: #046B26;"></i>
                  </div>
                  <span class="text-uppercase fw-bold text-white-50" style="font-size: 11px; letter-spacing: 1px;">AKREDITASI INSTITUSI</span>
                  <div class="fs-3 fw-bolder mt-1" style="color: #FED802; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    {{ $univAkreditasi->peringkat ?? 'BAIK SEKALI' }}
                  </div>
                  <span class="badge rounded-pill px-3 py-1 mt-2 text-white" style="background: rgba(255, 255, 255, 0.2); font-size: 12px;">
                    {{ $univAkreditasi->lembaga ?? 'BAN-PT' }}
                  </span>
                </div>
              </div>

              {{-- Deskripsi & Detail SK Universitas --}}
              <div class="col-md-8">
                <div class="badge px-3 py-1.5 rounded-pill mb-2 fw-bold" style="background: #FED802; color: #046B26; font-size: 12px;">
                  PERGURUAN TINGGI TERAKREDITASI
                </div>
                <h3 class="fw-bold mb-2 text-white">
                  {{ $univAkreditasi->nama ?? 'Universitas Ibnu Sina (UIS)' }}
                </h3>
                <p class="text-white-50 small mb-4" style="line-height: 1.7;">
                  Universitas Ibnu Sina secara resmi terakreditasi oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT), membuktikan komitmen mutu penyelenggaraan Tri Dharma Perguruan Tinggi yang unggul dan berkelanjutan di tingkat nasional.
                </p>

                <div class="row g-3 mb-4">
                  <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1);">
                      <div class="text-white-50 small fw-semibold">Nomor SK Akreditasi:</div>
                      <div class="fw-bold text-white text-truncate mt-1" style="font-size: 13.5px;" title="{{ $univAkreditasi->nomor_sk ?? '198/SK/BAN-PT/Ak/PT/III/2023' }}">
                        {{ $univAkreditasi->nomor_sk ?? '198/SK/BAN-PT/Ak/PT/III/2023' }}
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1);">
                      <div class="text-white-50 small fw-semibold">Masa Berlaku:</div>
                      <div class="fw-bold text-white mt-1" style="font-size: 13.5px;">
                        <i class="bi bi-calendar2-check text-warning me-1"></i>
                        {{ $univAkreditasi->masa_berlaku ?? '2023 - 2028' }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                  @if(!empty($univAkreditasi->file_sertifikat))
                    <a href="{{ $univAkreditasi->file_url }}" target="_blank" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: #FED802; color: #046B26; font-size: 14px;">
                      <i class="bi bi-file-earmark-pdf-fill fs-5"></i> Unduh Sertifikat Institusi (PDF)
                    </a>
                  @else
                    <button type="button" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: #FED802; color: #046B26; font-size: 14px;" onclick="alert('Salinan sertifikat resmi universitas dalam proses arsip digital.')">
                      <i class="bi bi-file-earmark-check fs-5"></i> Sertifikat Resmi Aktif
                    </button>
                  @endif

                  <a href="https://pddikti.kemdiktisaintek.go.id/" target="_blank" class="btn btn-outline-light px-3 py-2.5 rounded-pill small fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Verifikasi PD-DIKTI
                  </a>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- SECTION 2: AKREDITASI TINGKAT FAKULTAS --}}
    <div class="mb-5" data-aos="fade-up">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Tingkat Fakultas
        </span>
        <h3 class="fw-bold text-dark mt-2">Akreditasi Fakultas Universitas Ibnu Sina</h3>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
          Pusat pengelolaan akademik dan keilmuan fakultas dengan akreditasi teruji untuk menjamin mutu perkuliahan mahasiswa.
        </p>
      </div>

      <div class="row g-4 justify-content-center">
        @forelse($fakultasAkreditasis as $fak)
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column justify-content-between" style="border-top: 4px solid #046B26 !important; transition: transform 0.2s, box-shadow 0.2s;">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1); width: 44px; height: 44px;">
                    <i class="bi {{ str_contains($fak->nama, 'Pascasarjana') ? 'bi-mortarboard-fill' : 'bi-building' }} fs-5" style="color: #046B26;"></i>
                  </div>
                  <span class="badge {{ $fak->badge_class }} rounded-pill px-2.5 py-1 small fw-bold">
                    {{ $fak->peringkat }}
                  </span>
                </div>

                <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">{{ $fak->nama }}</h5>
                <div class="small text-muted mb-3 d-flex align-items-center gap-1">
                  <i class="bi bi-award text-success"></i> Lembaga: <strong>{{ $fak->lembaga }}</strong>
                </div>

                <div class="p-2.5 rounded-3 bg-light border small mb-3">
                  <div class="text-muted" style="font-size: 11px;">Nomor SK:</div>
                  <div class="fw-semibold text-dark text-truncate" title="{{ $fak->nomor_sk }}">{{ $fak->nomor_sk ?: 'SK Terlampir' }}</div>
                  <div class="text-muted mt-1" style="font-size: 11px;"><i class="bi bi-clock me-1"></i>Masa Berlaku: {{ $fak->masa_berlaku ?: '2023 - 2028' }}</div>
                </div>
              </div>

              <div>
                @if($fak->file_sertifikat)
                  <a href="{{ $fak->file_url }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill btn-sm fw-bold py-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Unduh Sertifikat PDF
                  </a>
                @else
                  <span class="btn btn-light w-100 rounded-pill btn-sm text-muted py-2 disabled">
                    <i class="bi bi-check2-circle text-success me-1"></i> Terakreditasi Resmi
                  </span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted py-4">Data akreditasi fakultas belum tersedia.</div>
        @endforelse
      </div>
    </div>

    {{-- SECTION 3: AKREDITASI SELURUH PROGRAM STUDI (11 PRODI) --}}
    <div class="mb-5" data-aos="fade-up">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Program Studi
        </span>
        <h3 class="fw-bold text-dark mt-2">Akreditasi Seluruh Program Studi (S1 & S2)</h3>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
          Daftar peringkat akreditasi, nomor SK, lembaga akreditasi (BAN-PT, LAM-INFOKOM, LAMEMBA, LAM-PTKes, LAM Teknik), serta sertifikat unduhan untuk 11 program studi UIS.
        </p>
      </div>

      {{-- Filter & Search Tabs Program Studi --}}
      <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
        <div class="row g-2 align-items-center justify-content-between">
          <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2" id="filterProdiGroup">
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-bold btn-prodi-filter active text-white" style="background-color: #046B26;" onclick="filterProdi('all', this)">
                Semua Program Studi ({{ $prodiAkreditasis->count() }})
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-prodi-filter bg-light text-dark" onclick="filterProdi('Program Pascasarjana', this)">
                Pascasarjana (S2)
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-prodi-filter bg-light text-dark" onclick="filterProdi('Fakultas Ekonomi dan Bisnis', this)">
                FEB (S1)
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-prodi-filter bg-light text-dark" onclick="filterProdi('Fakultas Sains dan Teknologi', this)">
                FST / Teknik (S1)
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-prodi-filter bg-light text-dark" onclick="filterProdi('Fakultas Ilmu Kesehatan', this)">
                FIKES (S1)
              </button>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="input-group">
              <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
              <input type="text" id="searchProdiInput" class="form-control bg-light border-0 small" placeholder="Cari nama prodi atau lembaga..." onkeyup="searchProdi(this.value)">
            </div>
          </div>
        </div>
      </div>

      {{-- Grid Kartu Akreditasi Program Studi --}}
      <div class="row g-3" id="prodiCardsContainer">
        @forelse($prodiAkreditasis as $prodi)
          @php
            $isS2 = str_contains($prodi->nama, 'S2') || $prodi->jenjang === 'S2';
            $badgeJenjang = $isS2 ? 'background: #4a148c; color: white;' : 'background: #046B26; color: white;';
          @endphp
          <div class="col-md-6 col-lg-4 prodi-card-item" data-fakultas="{{ $prodi->kategori_label }}" data-search="{{ strtolower($prodi->nama . ' ' . $prodi->lembaga . ' ' . $prodi->kategori_label . ' ' . $prodi->nomor_sk) }}">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column justify-content-between" style="border-left: 4px solid #046B26 !important;">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="badge rounded-pill px-2.5 py-1 small fw-bold" style="{{ $badgeJenjang }}">
                    {{ $isS2 ? 'Jenjang S2 Magister' : 'Jenjang S1 Sarjana' }}
                  </span>
                  <span class="badge {{ $prodi->badge_class }} rounded-pill px-2.5 py-1 small fw-bold">
                    {{ $prodi->peringkat }}
                  </span>
                </div>

                <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">{{ $prodi->nama }}</h5>
                <div class="small text-muted mb-3">{{ $prodi->kategori_label }}</div>

                <div class="p-3 rounded-3 bg-light border small mb-3">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-muted">Lembaga Akreditasi:</span>
                    <strong class="text-dark">{{ $prodi->lembaga }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-muted">Nomor SK:</span>
                    <strong class="text-dark text-truncate" style="max-width: 140px;" title="{{ $prodi->nomor_sk }}">{{ $prodi->nomor_sk ?: '-' }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Masa Berlaku:</span>
                    <strong class="text-dark">{{ $prodi->masa_berlaku ?: ($prodi->tahun_sk ? 'Tahun ' . $prodi->tahun_sk : '-') }}</strong>
                  </div>
                </div>
              </div>

              <div>
                @if($prodi->file_sertifikat)
                  <a href="{{ $prodi->file_url }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill btn-sm fw-bold py-2 d-flex align-items-center justify-content-center gap-1">
                    <i class="bi bi-download text-danger"></i> Unduh Sertifikat PDF
                  </a>
                @else
                  <a href="{{ route('homepage.program-studi.detail', Str::slug($prodi->nama)) }}" class="btn btn-outline-secondary w-100 rounded-pill btn-sm py-2">
                    <i class="bi bi-info-circle me-1"></i> Profil Program Studi
                  </a>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
            Data akreditasi program studi belum tersedia.
          </div>
        @endforelse
      </div>

      <div id="noProdiMatch" class="d-none text-center py-5 bg-white rounded-4 shadow-sm mt-3">
        <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
        <h6 class="fw-bold text-dark">Program Studi Tidak Ditemukan</h6>
        <p class="text-muted small mb-0">Coba gunakan kata kunci pencarian yang lain.</p>
      </div>

    </div>

    {{-- SECTION 4: KOTAK VERIFIKASI RESMI KEMENDIKBUD / BAN-PT --}}
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4" style="border-left: 6px solid #046B26 !important;">
          <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1); width: 56px; height: 56px; min-width: 56px;">
              <i class="bi bi-shield-check fs-2" style="color: #046B26;"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">Verifikasi Keabsahan Akreditasi Resmi</h5>
              <p class="text-muted small mb-0" style="line-height: 1.7;">
                Seluruh program studi dan institusi Universitas Ibnu Sina (UIS) telah tercatat secara sah dan resmi pada Pangkalan Data Pendidikan Tinggi (PD-DIKTI) Kementerian Pendidikan Tinggi, Sains, dan Teknologi Republik Indonesia serta BAN-PT.
              </p>
            </div>
          </div>
          <div class="d-flex flex-column flex-sm-row gap-2" style="min-width: 280px;">
            <a href="https://pddikti.kemdiktisaintek.go.id/" target="_blank" class="btn btn-outline-success rounded-pill fw-bold py-2.5 px-3 text-center" style="font-size: 13.5px;">
              <i class="bi bi-search me-1"></i> Cek di PD-DIKTI
            </a>
            <a href="https://www.banpt.or.id/" target="_blank" class="btn rounded-pill fw-bold py-2.5 px-3 text-center text-white" style="background: #046B26; font-size: 13.5px;">
              <i class="bi bi-award me-1"></i> Portal BAN-PT
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- JAVASCRIPT FILTER & SEARCH PRODI --}}
<script>
let currentFakultasFilter = 'all';

function filterProdi(fakultas, btn) {
  currentFakultasFilter = fakultas;

  // Toggle active button styling
  const buttons = document.querySelectorAll('.btn-prodi-filter');
  buttons.forEach(b => {
    b.classList.remove('active', 'text-white');
    b.classList.add('bg-light', 'text-dark');
    b.style.backgroundColor = '';
  });
  btn.classList.add('active', 'text-white');
  btn.classList.remove('bg-light', 'text-dark');
  btn.style.backgroundColor = '#046B26';

  applyFilters();
}

function searchProdi(keyword) {
  applyFilters();
}

function applyFilters() {
  const keyword = document.getElementById('searchProdiInput').value.toLowerCase().trim();
  const items = document.querySelectorAll('.prodi-card-item');
  let visibleCount = 0;

  items.forEach(item => {
    const itemFakultas = item.getAttribute('data-fakultas');
    const itemSearch = item.getAttribute('data-search');

    const matchFakultas = (currentFakultasFilter === 'all') || (itemFakultas === currentFakultasFilter);
    const matchSearch = (keyword === '') || (itemSearch.includes(keyword));

    if (matchFakultas && matchSearch) {
      item.classList.remove('d-none');
      visibleCount++;
    } else {
      item.classList.add('d-none');
    }
  });

  const noMatchBox = document.getElementById('noProdiMatch');
  if (visibleCount === 0) {
    noMatchBox.classList.remove('d-none');
  } else {
    noMatchBox.classList.add('d-none');
  }
}
</script>
@endsection
