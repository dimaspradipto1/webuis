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
     MAIN CONTENT (HANYA MEMUAT KALENDER & NOTE YANG DITANDAI)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" style="background-color: #f7faf7;">
  <div class="container">
    <div class="row g-4">
      
      {{-- Kolom Konten Utama: Kalender & Note --}}
      <div class="col-lg-8" data-aos="fade-up">

        {{-- Banner Gambar / Cover (Hanya jika diupload admin) --}}
        @if($item->gambar)
          <div class="mb-4 rounded-4 overflow-hidden shadow-sm border bg-white">
            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-100 img-fluid" style="max-height: 380px; object-fit: cover;">
          </div>
        @endif

        {{-- CARD UTAMA: KALENDER VISUAL & NOTE TANGGAL DITANDAI --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
          
          {{-- Header Kalender & Navigasi Bulan --}}
          <div class="card-header py-3 px-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #046B26;">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-calendar3 fs-5" style="color: #FED802;"></i>
              <h5 class="mb-0 fw-bold text-white">Kalender Akademik</h5>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
              {{-- Navigasi Bulan --}}
              <div class="btn-group shadow-sm">
                <button type="button" class="btn btn-sm btn-outline-light px-2.5" onclick="prevMonth()" title="Bulan Sebelumnya">
                  <i class="bi bi-chevron-left"></i>
                </button>
                <span id="calCurrentMonthYear" class="btn btn-sm btn-light fw-bold px-3 text-dark" style="min-width: 140px; cursor: default;">
                  Bulan Tahun
                </span>
                <button type="button" class="btn btn-sm btn-outline-light px-2.5" onclick="nextMonth()" title="Bulan Selanjutnya">
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>

              <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold shadow-sm" style="background: #FED802; color: #046B26;" onclick="goToToday()">
                Bulan Ini
              </button>

              {{-- Tombol Unduh PDF Resmi --}}
              @if($item->file_dokumen)
                <a href="{{ $item->file_dokumen_url }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" title="Unduh Salinan Dokumen Resmi">
                  <i class="bi bi-download"></i> Unduh PDF
                </a>
              @endif
            </div>
          </div>

          <div class="card-body p-4">
            
            {{-- Legenda Warna Kategori Note --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-3 border-bottom small">
              <span class="text-muted fw-bold me-1"><i class="bi bi-tags-fill text-success me-1"></i>Keterangan Warna:</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #e8f5e9; color: #1b5e20; border: 1px solid #a5d6a7;">● Perkuliahan</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #e3f2fd; color: #0d47a1; border: 1px solid #90caf9;">● Registrasi / KRS</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #fff8e1; color: #e65100; border: 1px solid #ffe082;">● Ujian (UTS/UAS)</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #f3e5f5; color: #4a148c; border: 1px solid #ce93d8;">● Wisuda / Yudisium</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #ffebee; color: #b71c1c; border: 1px solid #ef9a9a;">● Libur Semester</span>
              <span class="badge rounded-pill px-2.5 py-1" style="background: #e0f2f1; color: #004d40; border: 1px solid #80cbc4;">● Akademik</span>
            </div>

            {{-- Grid Tampilan Kalender --}}
            <div class="calendar-wrapper mb-4">
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

            <hr class="my-4 text-muted opacity-25">

            {{-- BAGIAN NOTE / CATATAN TANGGAL YANG DITANDAI --}}
            <div class="note-section">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="rounded-circle p-1.5 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1);">
                    <i class="bi bi-bookmark-check-fill text-success fs-5"></i>
                  </div>
                  <h5 class="mb-0 fw-bold text-dark">
                    Catatan Kegiatan & Tanggal Ditandai
                  </h5>
                </div>

                {{-- Filter Tab Catatan (Bulan Ini / Semua Catatan Semester) --}}
                <div class="btn-group btn-group-sm rounded-pill p-1 bg-light border">
                  <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold active text-white" id="tabNoteMonth" style="background-color: #046B26;" onclick="switchNoteTab('month')">
                    Bulan Terpilih (<span id="countMonthNotes">0</span>)
                  </button>
                  <button type="button" class="btn btn-sm rounded-pill px-3 fw-semibold text-dark" id="tabNoteAll" onclick="switchNoteTab('all')">
                    Semua Catatan Semester
                  </button>
                </div>
              </div>

              {{-- Kontainer Daftar Note Tanggal yang Ditandai --}}
              <div id="notesContainer" class="d-flex flex-column gap-2.5">
                <!-- Di-generate via JavaScript secara dinamis -->
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

        {{-- Widget Bantuan & Kontak --}}
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

{{-- JAVASCRIPT LOGIKA KALENDER & NOTE TANGGAL DITANDAI --}}
<script>
const rawAgendaData = @json($agendaItems);

let currentDate = new Date();
let activeNoteTab = 'month'; // 'month' or 'all'

const monthNames = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

function getCategoryTheme(kategori) {
  switch (kategori) {
    case 'Perkuliahan':
      return { bg: '#e8f5e9', color: '#1b5e20', border: '#a5d6a7', dot: '#2e7d32', badge: 'bg-success text-white' };
    case 'Registrasi':
      return { bg: '#e3f2fd', color: '#0d47a1', border: '#90caf9', dot: '#1565c0', badge: 'bg-primary text-white' };
    case 'Ujian':
      return { bg: '#fff8e1', color: '#e65100', border: '#ffe082', dot: '#ef6c00', badge: 'bg-warning text-dark' };
    case 'Wisuda':
      return { bg: '#f3e5f5', color: '#4a148c', border: '#ce93d8', dot: '#6a1b9a', badge: 'bg-purple text-white' };
    case 'Libur':
      return { bg: '#ffebee', color: '#b71c1c', border: '#ef9a9a', dot: '#c62828', badge: 'bg-danger text-white' };
    case 'Akademik':
    default:
      return { bg: '#e0f2f1', color: '#004d40', border: '#80cbc4', dot: '#00695c', badge: 'bg-teal text-white' };
  }
}

function renderCalendar() {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  // Update Header Bulan & Tahun
  const calHeader = document.getElementById('calCurrentMonthYear');
  if (calHeader) calHeader.innerText = `${monthNames[month]} ${year}`;

  const firstDayIndex = new Date(year, month, 1).getDay(); // 0 is Sunday
  const lastDay = new Date(year, month + 1, 0).getDate();
  const prevLastDay = new Date(year, month, 0).getDate();

  const daysGrid = document.getElementById('calendarDaysGrid');
  if (!daysGrid) return;
  daysGrid.innerHTML = '';

  const today = new Date();
  const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;

  // Previous month dates padding
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
    const primaryEvent = hasEvents ? dayEvents[0] : null;
    const theme = primaryEvent ? getCategoryTheme(primaryEvent.kategori) : null;

    dayDiv.className = `col p-1.5 border rounded-3 position-relative ${isToday ? 'border-success border-2' : 'border-light'} ${hasEvents ? 'shadow-xs' : ''}`;
    dayDiv.style.minHeight = '68px';
    dayDiv.style.backgroundColor = hasEvents ? theme.bg : '#ffffff';
    dayDiv.style.transition = 'all 0.2s';
    dayDiv.style.cursor = hasEvents ? 'pointer' : 'default';

    let dayNumberHtml = '';
    if (hasEvents) {
      dayNumberHtml = `
        <div class="fw-bold small rounded-circle d-inline-flex align-items-center justify-content-center shadow-xs" 
             style="width: 28px; height: 28px; background: ${theme.dot}; color: #ffffff;">
          ${d}
        </div>
      `;
    } else if (isToday) {
      dayNumberHtml = `
        <div class="fw-bold small rounded-circle d-inline-flex align-items-center justify-content-center" 
             style="width: 28px; height: 28px; background: #046B26; color: #ffffff;">
          ${d}
        </div>
      `;
    } else {
      dayNumberHtml = `
        <div class="fw-semibold small text-dark d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
          ${d}
        </div>
      `;
    }

    // Additional event dot indicators if more than 1 event
    let dotsHtml = '';
    if (dayEvents.length > 1) {
      dotsHtml = `<div class="d-flex justify-content-center gap-1 mt-1">`;
      dayEvents.forEach(ev => {
        const evTheme = getCategoryTheme(ev.kategori);
        dotsHtml += `<span class="rounded-circle" style="width: 6px; height: 6px; background: ${evTheme.dot};"></span>`;
      });
      dotsHtml += `</div>`;
    }

    dayDiv.innerHTML = `${dayNumberHtml}${dotsHtml}`;

    if (hasEvents) {
      dayDiv.title = dayEvents.map(e => `${e.kegiatan} (${e.kategori})`).join('; ');
      dayDiv.onclick = () => highlightNote(dayEvents[0]);
    }

    daysGrid.appendChild(dayDiv);
  }

  renderNotes();
}

function renderNotes() {
  const container = document.getElementById('notesContainer');
  if (!container) return;
  container.innerHTML = '';

  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  const monthStr = String(month + 1).padStart(2, '0');

  // Filter events for this month
  const monthEvents = rawAgendaData.filter(item => {
    if (!item.tanggal_mulai) return false;
    const startM = item.tanggal_mulai.substring(5, 7);
    const endM = item.tanggal_selesai ? item.tanggal_selesai.substring(5, 7) : startM;
    return monthStr >= startM && monthStr <= endM;
  });

  const countBadge = document.getElementById('countMonthNotes');
  if (countBadge) countBadge.innerText = monthEvents.length;

  const eventsToShow = (activeNoteTab === 'month') ? monthEvents : rawAgendaData;

  if (eventsToShow.length === 0) {
    container.innerHTML = `
      <div class="p-4 text-center text-muted bg-light rounded-4 border">
        <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
        <div class="fw-semibold">Tidak ada catatan kegiatan akademik pada bulan ${monthNames[month]} ${year}.</div>
        <p class="small text-muted mb-0">Klik tombol "Bulan Ini" atau navigasi ke bulan perkuliahan lainnya.</p>
      </div>
    `;
    return;
  }

  eventsToShow.forEach(ev => {
    const theme = getCategoryTheme(ev.kategori);
    const card = document.createElement('div');
    card.id = `note-${ev.tanggal_mulai}-${(ev.kegiatan || '').replace(/[^a-zA-Z0-9]/g, '_')}`;
    card.className = 'p-3 rounded-4 border bg-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 shadow-xs';
    card.style.borderLeft = `5px solid ${theme.dot} !important`;
    card.style.transition = 'all 0.3s ease';

    // Format Tanggal
    let tglText = formatIndoFull(ev.tanggal_mulai);
    if (ev.tanggal_selesai && ev.tanggal_selesai !== ev.tanggal_mulai) {
      tglText = `${formatIndoFull(ev.tanggal_mulai)} s/d ${formatIndoFull(ev.tanggal_selesai)}`;
    }

    card.innerHTML = `
      <div class="d-flex align-items-start gap-3">
        <div class="rounded-3 p-2 text-center shadow-xs" style="background: ${theme.bg}; color: ${theme.color}; min-width: 95px; border: 1px solid ${theme.border};">
          <div class="small text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">TANGGAL</div>
          <div class="fw-bold" style="font-size: 12.5px; line-height: 1.3;">${tglText}</div>
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">${ev.kegiatan}</h6>
            <span class="badge rounded-pill px-2.5 py-0.5 small fw-bold" style="background: ${theme.bg}; color: ${theme.color}; border: 1px solid ${theme.border}; font-size: 11px;">
              ● ${ev.kategori}
            </span>
          </div>
          <div class="text-muted small">${ev.keterangan || ('Kegiatan resmi semester ' + (ev.semester || 'Ganjil'))}</div>
        </div>
      </div>
      <div class="text-sm-end">
        <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1 small">
          Semester ${ev.semester || 'Ganjil'}
        </span>
      </div>
    `;

    container.appendChild(card);
  });
}

function highlightNote(ev) {
  const cardId = `note-${ev.tanggal_mulai}-${(ev.kegiatan || '').replace(/[^a-zA-Z0-9]/g, '_')}`;
  const el = document.getElementById(cardId);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    el.style.backgroundColor = '#fff9db';
    el.style.transform = 'scale(1.02)';
    setTimeout(() => {
      el.style.backgroundColor = '#ffffff';
      el.style.transform = 'scale(1)';
    }, 1500);
  }
}

function formatIndoFull(dateStr) {
  if (!dateStr) return '';
  const parts = dateStr.split('-');
  if (parts.length < 3) return dateStr;
  const d = parseInt(parts[2], 10);
  const m = monthNames[parseInt(parts[1], 10) - 1].substring(0, 3);
  return `${d} ${m}`;
}

function switchNoteTab(tab) {
  activeNoteTab = tab;
  const tabMonth = document.getElementById('tabNoteMonth');
  const tabAll = document.getElementById('tabNoteAll');

  if (tab === 'month') {
    tabMonth.classList.add('active', 'text-white');
    tabMonth.style.backgroundColor = '#046B26';
    tabAll.classList.remove('active', 'text-white');
    tabAll.style.backgroundColor = '';
  } else {
    tabAll.classList.add('active', 'text-white');
    tabAll.style.backgroundColor = '#046B26';
    tabMonth.classList.remove('active', 'text-white');
    tabMonth.style.backgroundColor = '';
  }

  renderNotes();
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
