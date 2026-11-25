@extends('layouts.frontend.template')

@section('title', ($item->judul ?? 'Kalender Akademik') . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'kalender-akademik',
    'heroClass' => 'akademik-hero',
    'defaultTitle' => $item->judul ?? 'Kalender Akademik',
    'defaultSubtitle' => $item->subjudul ?? 'Jadwal perkuliahan, registrasi, UTS, UAS, dan kegiatan akademik fakultas.',
    'defaultActive' => 'Kalender Akademik'
])

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" style="background-color: #f7faf7;">
  <div class="container">
    <div class="row g-4">
      
      {{-- Kolom Konten Utama --}}
      <div class="col-lg-8" data-aos="fade-up">
        
        {{-- Banner Gambar / Cover Kalender (Jika Ada) --}}
        @if($item->gambar)
          <div class="mb-4 rounded-4 overflow-hidden shadow-sm border bg-white">
            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-100 img-fluid" style="max-height: 420px; object-fit: cover;">
          </div>
        @endif

        {{-- Box Unduh File Resmi PDF Kalender --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 text-white" style="background: linear-gradient(135deg, #046B26 0%, #024719 100%); border-left: 6px solid #FED802 !important;">
          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle p-3 d-flex align-items-center justify-content-center shadow" style="background: rgba(254, 216, 2, 0.2); width: 56px; height: 56px; min-width: 56px;">
                <i class="bi bi-file-earmark-pdf-fill fs-2" style="color: #FED802;"></i>
              </div>
              <div>
                <span class="badge px-2.5 py-1 rounded-pill mb-1 fw-bold" style="background: #FED802; color: #046B26; font-size: 11px;">DOKUMEN RESMI</span>
                <h5 class="fw-bold mb-1 text-white">{{ $item->file_nama ?: 'Kalender Akademik Universitas Ibnu Sina' }}</h5>
                <p class="mb-0 text-white-50 small">Unduh salinan resmi Surat Keputusan (SK) Kalender Akademik format PDF.</p>
              </div>
            </div>
            <div>
              @if($item->file_dokumen)
                <a href="{{ $item->file_dokumen_url }}" target="_blank" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: #FED802; color: #034b1a; font-size: 14px;">
                  <i class="bi bi-download fs-5"></i> Unduh PDF Resmi
                </a>
              @else
                <button type="button" class="btn btn-outline-light px-3 py-2 rounded-pill small" disabled>
                  <i class="bi bi-clock me-1"></i> File PDF Segera Tersedia
                </button>
              @endif
            </div>
          </div>
        </div>

        {{-- Deskripsi Pengantar --}}
        @if(!empty($item->deskripsi))
          <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
              <i class="bi bi-info-circle-fill" style="color: #046B26;"></i>
              Ketentuan & Informasi Kalender Akademik
            </h5>
            <div class="article-content" style="font-size: 15px; line-height: 1.8; color: #374151;">
              {!! $item->deskripsi !!}
            </div>
          </div>
        @endif

        {{-- WIDGET KALENDER VISUAL INTERAKTIF (SEPERTI DI SISTEM / SIAKAD) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
          <div class="card-header py-3 px-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: #046B26;">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-calendar3 fs-5" style="color: #FED802;"></i>
              <h5 class="mb-0 fw-bold text-white">Kalender Visual Akademik</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
              <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="prevMonth()">
                <i class="bi bi-chevron-left"></i>
              </button>
              <span id="calCurrentMonthYear" class="fw-bold px-2 text-white" style="font-size: 15px; min-width: 150px; text-align: center;">Bulan Tahun</span>
              <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="nextMonth()">
                <i class="bi bi-chevron-right"></i>
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold ms-1" style="background: #FED802; color: #046B26;" onclick="goToToday()">
                Bulan Ini
              </button>
            </div>
          </div>

          <div class="card-body p-4">
            {{-- Keterangan Legenda Kategori Warna --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-3 border-bottom small">
              <span class="text-muted fw-bold me-1">Kategori Agenda:</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #e8f5e9; color: #1b5e20; border: 1px solid #c8e6c9;">● Perkuliahan</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #e3f2fd; color: #0d47a1; border: 1px solid #bbdefb;">● Registrasi & KRS</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #fff8e1; color: #f57f17; border: 1px solid #ffe082;">● Ujian (UTS/UAS)</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #f3e5f5; color: #4a148c; border: 1px solid #e1bee7;">● Wisuda / Yudisium</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #ffebee; color: #b71c1c; border: 1px solid #ffcdd2;">● Libur Semester</span>
            </div>

            {{-- Grid Kalender --}}
            <div class="calendar-wrapper">
              <div class="row g-1 text-center fw-bold text-muted small mb-2 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">
                <div class="col" style="color: #dc3545;">Minggu</div>
                <div class="col">Senin</div>
                <div class="col">Selasa</div>
                <div class="col">Rabu</div>
                <div class="col">Kamis</div>
                <div class="col">Jumat</div>
                <div class="col">Sabtu</div>
              </div>
              <div class="row g-1 text-center" id="calendarDaysGrid">
                <!-- Di-generate via JavaScript -->
              </div>
            </div>

            {{-- Detail Agenda Bulan Terpilih --}}
            <div class="mt-4 pt-3 border-top">
              <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-card-checklist text-success"></i>
                Daftar Agenda Akademik Bulan <span id="labelMonthEvents" class="text-primary">Ini</span>:
              </h6>
              <div id="calendarMonthEventsList" class="d-flex flex-column gap-2">
                <!-- Di-generate via JavaScript -->
              </div>
            </div>
          </div>
        </div>

        {{-- TABEL LINIMASA PER SEMESTER (GANJIL & GENAP) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
          <div class="card-header bg-white py-3 px-4 border-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
              <div>
                <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                  <i class="bi bi-clock-history text-success"></i>
                  Linimasa Jadwal Semester 2026/2027
                </h5>
                <p class="text-muted small mb-0">Rincian seluruh kegiatan akademik tahun ajaran berjalan.</p>
              </div>

              <ul class="nav nav-pills gap-1" id="semesterTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active rounded-pill px-3 py-1.5 fw-semibold small" id="ganjil-tab" data-bs-toggle="pill" data-bs-target="#ganjil" type="button" role="tab" style="background-color: #046B26;">
                    Semester Ganjil
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link rounded-pill px-3 py-1.5 fw-semibold small bg-light text-dark" id="genap-tab" data-bs-toggle="pill" data-bs-target="#genap" type="button" role="tab">
                    Semester Genap
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <div class="card-body p-0">
            <div class="tab-content" id="semesterTabContent">
              
              {{-- Tab Semester Ganjil --}}
              <div class="tab-pane fade show active" id="ganjil" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase">
                      <tr>
                        <th class="ps-4" style="width: 45px;">No</th>
                        <th style="width: 220px;">Linimasa / Tanggal</th>
                        <th>Kegiatan Akademik</th>
                        <th style="width: 140px;">Kategori</th>
                        <th class="pe-4">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $ganjilAgendas = collect($agendaItems)->where('semester', 'Ganjil')->values();
                      @endphp
                      @forelse($ganjilAgendas as $idx => $ag)
                        <tr>
                          <td class="ps-4 fw-semibold text-muted">{{ $idx + 1 }}</td>
                          <td>
                            <div class="fw-bold text-dark" style="font-size: 13.5px;">
                              {{ \Carbon\Carbon::parse($ag['tanggal_mulai'])->translatedFormat('d M Y') }}
                              @if(!empty($ag['tanggal_selesai']) && $ag['tanggal_selesai'] !== $ag['tanggal_mulai'])
                                <span class="text-muted fw-normal">s/d</span><br>
                                {{ \Carbon\Carbon::parse($ag['tanggal_selesai'])->translatedFormat('d M Y') }}
                              @endif
                            </div>
                          </td>
                          <td>
                            <div class="fw-bold text-dark">{{ $ag['kegiatan'] }}</div>
                          </td>
                          <td>
                            @php
                              $kat = $ag['kategori'] ?? 'Akademik';
                              $badgeStyle = match($kat) {
                                  'Perkuliahan' => 'background: #e8f5e9; color: #1b5e20;',
                                  'Registrasi' => 'background: #e3f2fd; color: #0d47a1;',
                                  'Ujian' => 'background: #fff8e1; color: #f57f17;',
                                  'Wisuda' => 'background: #f3e5f5; color: #4a148c;',
                                  'Libur' => 'background: #ffebee; color: #b71c1c;',
                                  default => 'background: #f0fdf4; color: #046B26;'
                              };
                            @endphp
                            <span class="badge rounded-pill px-2.5 py-1 small fw-bold" style="{{ $badgeStyle }}">
                              {{ $kat }}
                            </span>
                          </td>
                          <td class="pe-4 text-muted small">
                            {{ $ag['keterangan'] ?: '-' }}
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="5" class="text-center py-4 text-muted">Belum ada agenda semester ganjil.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>

              {{-- Tab Semester Genap --}}
              <div class="tab-pane fade" id="genap" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase">
                      <tr>
                        <th class="ps-4" style="width: 45px;">No</th>
                        <th style="width: 220px;">Linimasa / Tanggal</th>
                        <th>Kegiatan Akademik</th>
                        <th style="width: 140px;">Kategori</th>
                        <th class="pe-4">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $genapAgendas = collect($agendaItems)->where('semester', 'Genap')->values();
                      @endphp
                      @forelse($genapAgendas as $idx => $ag)
                        <tr>
                          <td class="ps-4 fw-semibold text-muted">{{ $idx + 1 }}</td>
                          <td>
                            <div class="fw-bold text-dark" style="font-size: 13.5px;">
                              {{ \Carbon\Carbon::parse($ag['tanggal_mulai'])->translatedFormat('d M Y') }}
                              @if(!empty($ag['tanggal_selesai']) && $ag['tanggal_selesai'] !== $ag['tanggal_mulai'])
                                <span class="text-muted fw-normal">s/d</span><br>
                                {{ \Carbon\Carbon::parse($ag['tanggal_selesai'])->translatedFormat('d M Y') }}
                              @endif
                            </div>
                          </td>
                          <td>
                            <div class="fw-bold text-dark">{{ $ag['kegiatan'] }}</div>
                          </td>
                          <td>
                            @php
                              $kat = $ag['kategori'] ?? 'Akademik';
                              $badgeStyle = match($kat) {
                                  'Perkuliahan' => 'background: #e8f5e9; color: #1b5e20;',
                                  'Registrasi' => 'background: #e3f2fd; color: #0d47a1;',
                                  'Ujian' => 'background: #fff8e1; color: #f57f17;',
                                  'Wisuda' => 'background: #f3e5f5; color: #4a148c;',
                                  'Libur' => 'background: #ffebee; color: #b71c1c;',
                                  default => 'background: #f0fdf4; color: #046B26;'
                              };
                            @endphp
                            <span class="badge rounded-pill px-2.5 py-1 small fw-bold" style="{{ $badgeStyle }}">
                              {{ $kat }}
                            </span>
                          </td>
                          <td class="pe-4 text-muted small">
                            {{ $ag['keterangan'] ?: '-' }}
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="5" class="text-center py-4 text-muted">Belum ada agenda semester genap.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

      {{-- Kolom Sidebar Navigasi Akademik --}}
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Widget Menu Akademik & Informasi --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
          <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
            <i class="bi bi-mortarboard-fill text-success"></i> Layanan Akademik
          </h6>
          <nav class="d-flex flex-column gap-2">
            <a href="{{ route('homepage.kalender-akademik') }}" class="p-2.5 rounded-3 d-flex align-items-center gap-2 fw-bold text-white shadow-sm" style="background: #046B26; text-decoration: none;">
              <i class="bi bi-calendar-check-fill text-warning"></i>
              <span>Kalender Akademik</span>
            </a>
            <a href="{{ route('homepage.akreditasi') }}" class="p-2.5 rounded-3 d-flex align-items-center gap-2 text-dark border bg-light" style="text-decoration: none; transition: all 0.2s;">
              <i class="bi bi-patch-check-fill text-success"></i>
              <span class="fw-semibold">Sertifikat Akreditasi</span>
            </a>
            <a href="{{ route('homepage.kurikulum') }}" class="p-2.5 rounded-3 d-flex align-items-center gap-2 text-dark border bg-light" style="text-decoration: none; transition: all 0.2s;">
              <i class="bi bi-journal-text text-primary"></i>
              <span class="fw-semibold">Kurikulum & Capaian</span>
            </a>
            <a href="{{ route('homepage.pedoman-akademik') }}" class="p-2.5 rounded-3 d-flex align-items-center gap-2 text-dark border bg-light" style="text-decoration: none; transition: all 0.2s;">
              <i class="bi bi-book text-success"></i>
              <span class="fw-semibold">Pedoman Akademik</span>
            </a>
            <a href="{{ route('homepage.sistem-akademik') }}" class="p-2.5 rounded-3 d-flex align-items-center gap-2 text-dark border bg-light" style="text-decoration: none; transition: all 0.2s;">
              <i class="bi bi-laptop text-info"></i>
              <span class="fw-semibold">Sistem Akademik (SIAKAD)</span>
            </a>
          </nav>
        </div>

        {{-- Widget Akses SIAKAD --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white" style="background: #032e12; border: 1px solid #046B26;">
          <div class="badge px-3 py-1 rounded-pill mb-2 fw-bold" style="background: #FED802; color: #046B26; font-size: 11px;">
            PORTAL SIAKAD
          </div>
          <h5 class="fw-bold text-white mb-2">SIAKAD Universitas Ibnu Sina</h5>
          <p class="text-white-50 small mb-3">
            Akses pengisian Kartu Rencana Studi (KRS), cetak KHS, presensi perkuliahan, dan bimbingan akademik online.
          </p>
          <a href="https://siakad.uis.ac.id" target="_blank" class="btn w-100 rounded-pill fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: #FED802; color: #034b1a; font-size: 14px;">
            <i class="bi bi-box-arrow-up-right"></i> Masuk ke Portal SIAKAD
          </a>
        </div>

        {{-- Widget Kontak Layanan Akademik --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-headset text-success me-2"></i>Bantuan & Informasi</h6>
          <p class="text-muted small mb-3">
            Ada pertanyaan mengenai tanggal akademik, dispensasi, atau jadwal yudisium? Hubungi Bagian Administrasi Akademik UIS.
          </p>
          <a href="{{ route('homepage.kontak') }}" class="btn btn-outline-success w-100 rounded-pill fw-bold py-2" style="font-size: 13.5px;">
            <i class="bi bi-telephone-fill me-1"></i> Hubungi Tata Usaha
          </a>
        </div>

      </div>

    </div>
  </div>
</section>

{{-- JAVASCRIPT KALENDER VISUAL INTERAKTIF --}}
<script>
const rawAgendaData = @json($agendaItems);

let currentDate = new Date();

const monthNames = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

function renderCalendar() {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  // Update Header Bulan & Tahun
  const calHeader = document.getElementById('calCurrentMonthYear');
  if (calHeader) calHeader.innerText = `${monthNames[month]} ${year}`;
  
  const labelMonthEvents = document.getElementById('labelMonthEvents');
  if (labelMonthEvents) labelMonthEvents.innerText = `${monthNames[month]} ${year}`;

  const firstDayIndex = new Date(year, month, 1).getDay(); // 0 is Sunday
  const lastDay = new Date(year, month + 1, 0).getDate();
  const prevLastDay = new Date(year, month, 0).getDate();

  const daysGrid = document.getElementById('calendarDaysGrid');
  if (!daysGrid) return;
  daysGrid.innerHTML = '';

  const today = new Date();
  const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;

  // Previous month dates
  for (let i = firstDayIndex; i > 0; i--) {
    const dayDiv = document.createElement('div');
    dayDiv.className = 'col p-2 text-muted opacity-25 small';
    dayDiv.style.minHeight = '65px';
    dayDiv.innerHTML = `<span class="small">${prevLastDay - i + 1}</span>`;
    daysGrid.appendChild(dayDiv);
  }

  // Current month dates
  for (let d = 1; d <= lastDay; d++) {
    const dayDiv = document.createElement('div');
    const dayString = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
    const isToday = isCurrentMonth && today.getDate() === d;

    // Check if any agenda spans this date
    const dayEvents = rawAgendaData.filter(item => {
      if (!item.tanggal_mulai) return false;
      const start = item.tanggal_mulai;
      const end = item.tanggal_selesai || item.tanggal_mulai;
      return dayString >= start && dayString <= end;
    });

    const hasEvents = dayEvents.length > 0;

    dayDiv.className = `col p-1.5 border rounded-3 position-relative ${isToday ? 'border-success' : 'border-light'} ${hasEvents ? 'bg-light' : ''}`;
    dayDiv.style.minHeight = '68px';
    dayDiv.style.cursor = hasEvents ? 'pointer' : 'default';

    let dayBadgeColor = isToday ? 'background: #046B26; color: white;' : 'color: #374151;';
    let dotsHtml = '';

    if (hasEvents) {
      dotsHtml = `<div class="d-flex justify-content-center gap-1 mt-1 flex-wrap">`;
      dayEvents.forEach(ev => {
        let dotColor = '#046B26';
        if (ev.kategori === 'Ujian') dotColor = '#f57f17';
        else if (ev.kategori === 'Registrasi') dotColor = '#0d47a1';
        else if (ev.kategori === 'Wisuda') dotColor = '#4a148c';
        else if (ev.kategori === 'Libur') dotColor = '#b71c1c';
        dotsHtml += `<span class="rounded-circle" style="width: 7px; height: 7px; background: ${dotColor};" title="${ev.kegiatan}"></span>`;
      });
      dotsHtml += `</div>`;
    }

    dayDiv.innerHTML = `
      <div class="fw-bold small rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; ${dayBadgeColor}">
        ${d}
      </div>
      ${dotsHtml}
    `;

    if (hasEvents) {
      dayDiv.onclick = () => showEventModal(dayEvents, dayString);
    }

    daysGrid.appendChild(dayDiv);
  }

  // Populate Month Events List Below Calendar
  renderMonthEventsList(year, month);
}

function renderMonthEventsList(year, month) {
  const container = document.getElementById('calendarMonthEventsList');
  if (!container) return;
  container.innerHTML = '';

  const monthStr = String(month + 1).padStart(2, '0');
  const monthEvents = rawAgendaData.filter(item => {
    if (!item.tanggal_mulai) return false;
    const startM = item.tanggal_mulai.substring(5, 7);
    const endM = item.tanggal_selesai ? item.tanggal_selesai.substring(5, 7) : startM;
    return monthStr >= startM && monthStr <= endM;
  });

  if (monthEvents.length === 0) {
    container.innerHTML = `
      <div class="p-3 text-center text-muted small bg-light rounded-3">
        <i class="bi bi-calendar-x me-1"></i> Tidak ada kegiatan akademik khusus di bulan ini.
      </div>
    `;
    return;
  }

  monthEvents.forEach(ev => {
    let catClass = 'bg-success-subtle text-success';
    if (ev.kategori === 'Ujian') catClass = 'bg-warning-subtle text-dark';
    else if (ev.kategori === 'Registrasi') catClass = 'bg-primary-subtle text-primary';
    else if (ev.kategori === 'Wisuda') catClass = 'bg-purple-subtle text-dark';
    else if (ev.kategori === 'Libur') catClass = 'bg-danger-subtle text-danger';

    const card = document.createElement('div');
    card.className = 'p-3 rounded-3 border bg-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 shadow-xs';
    card.innerHTML = `
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 px-3 py-1.5 text-center" style="background: #eef7f0; color: #046B26; min-width: 90px;">
          <div class="fw-bold" style="font-size: 13px;">${formatIndoDate(ev.tanggal_mulai)}</div>
        </div>
        <div>
          <div class="fw-bold text-dark" style="font-size: 14.5px;">${ev.kegiatan}</div>
          <div class="text-muted small">${ev.keterangan || 'Jadwal resmi semester ' + (ev.semester || 'Ganjil')}</div>
        </div>
      </div>
      <div>
        <span class="badge rounded-pill px-2.5 py-1 ${catClass} small fw-semibold">${ev.kategori || 'Akademik'}</span>
      </div>
    `;
    container.appendChild(card);
  });
}

function formatIndoDate(dateStr) {
  if (!dateStr) return '';
  const parts = dateStr.split('-');
  if (parts.length < 3) return dateStr;
  return `${parts[2]} ${monthNames[parseInt(parts[1], 10) - 1].substring(0, 3)}`;
}

function prevMonth() {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
}

function nextMonth() {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
}

function goToToday() {
  currentDate = new Date();
  renderCalendar();
}

document.addEventListener('DOMContentLoaded', function() {
  renderCalendar();
});
</script>
@endsection
