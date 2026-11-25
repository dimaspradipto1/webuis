@extends('layouts.frontend.template')

@section('title', ($item->judul ?? 'Kalender Akademik') . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HEADER & BREADCRUMB
═══════════════════════════════════════════════ -->
<section class="py-3 border-bottom" style="background-color: #ffffff;">
  <div class="container-fluid px-lg-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div>
        <h4 class="fw-bold mb-0 text-dark">Kalender Akademik</h4>
        <div class="text-muted small">Tahun Akademik 2026/2027 Universitas Ibnu Sina</div>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('homepage') }}" class="text-decoration-none text-muted">Beranda</a></li>
          <li class="breadcrumb-item"><a href="{{ route('homepage.kalender-akademik') }}" class="text-decoration-none text-muted">Akademik</a></li>
          <li class="breadcrumb-item active text-success fw-semibold" aria-current="page">Kalender</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     MAIN CALENDAR DASHBOARD (PERSIS SEPERTI GAMBAR)
═══════════════════════════════════════════════ -->
<section class="py-4" style="background-color: #f3f5f8; min-height: 80vh;">
  <div class="container-fluid px-lg-5">
    @if(!$item->is_active)
      <div class="alert alert-warning border-0 rounded-4 shadow-sm p-4 mb-4 d-flex align-items-center gap-3">
        <i class="bi bi-exclamation-triangle-fill fs-2 text-warning"></i>
        <div>
          <h6 class="fw-bold mb-1 text-dark">Kalender Akademik Dalam Proses Penyesuaian</h6>
          <div class="small text-muted">Jadwal dan linimasa perkuliahan sedang dalam proses peninjauan / pembaruan resmi oleh Biro Administrasi Akademik UIS.</div>
        </div>
      </div>
    @endif
    <div class="row g-4">
      
      {{-- ══════════════════════════════════════════════
           SIDEBAR KIRI: BUTTON, MINI CALENDAR, CATEGORIES, UPCOMING
      ══════════════════════════════════════════════ --}}
      <div class="col-xl-3 col-lg-4">
        
        {{-- Tombol Unduh SK Kalender (PDF) --}}
        <div class="mb-3">
          @if($item->file_dokumen)
            <a href="{{ $item->file_dokumen_url }}" target="_blank" class="btn w-100 py-2.5 rounded-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #046B26; font-size: 14px;">
              <i class="bi bi-file-earmark-pdf-fill fs-5"></i> Unduh Kalender (PDF)
            </a>
          @else
            <button type="button" class="btn w-100 py-2.5 rounded-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #046B26; font-size: 14px;" onclick="alert('Salinan SK Kalender Akademik resmi dalam proses arsip digital.')">
              <i class="bi bi-calendar2-check-fill fs-5"></i> Kalender Resmi UIS
            </button>
          @endif
        </div>

        {{-- Categories Card --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
          <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
            <h6 class="fw-bold mb-0 text-dark small">Categories</h6>
            <span class="text-muted small" style="font-size: 11px;" id="resetCategoryFilterBtn" onclick="resetCategories()" style="cursor: pointer;">Semua</span>
          </div>
          <div class="d-flex flex-column gap-2" id="categoriesList">
            <!-- Di-generate via JavaScript -->
          </div>
        </div>

        {{-- Upcoming Events Card --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
          <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
            <h6 class="fw-bold mb-0 text-dark small">Upcoming Events</h6>
            <span class="badge bg-light text-muted small rounded-pill" id="upcomingCountBadge">0</span>
          </div>
          <div class="d-flex flex-column gap-2.5 overflow-auto" style="max-height: 380px;" id="upcomingEventsList">
            <!-- Di-generate via JavaScript -->
          </div>
        </div>

      </div>

      {{-- ══════════════════════════════════════════════
           AREA UTAMA: FULL CALENDAR GRID
      ══════════════════════════════════════════════ --}}
      <div class="col-xl-9 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
          
          {{-- Toolbar Atas: < Today > Wednesday, November 25, 2026 ... Day | Week | Month --}}
          <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            
            {{-- Navigasi & Judul Tanggal --}}
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 rounded-start-3" onclick="mainPrev()" title="Sebelumnya">
                  <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-semibold" onclick="mainToday()">
                  Today
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 rounded-end-3" onclick="mainNext()" title="Selanjutnya">
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>

              <h5 class="mb-0 fw-bold text-dark ms-2" id="mainCalendarTitle">
                Wednesday, November 25, 2026
              </h5>
            </div>

            {{-- View Switcher: Day | Week | Month --}}
            <div class="btn-group shadow-xs rounded-3 overflow-hidden" role="group">
              <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold view-btn" id="btnViewDay" onclick="switchView('day')">
                Day
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold view-btn" id="btnViewWeek" onclick="switchView('week')">
                Week
              </button>
              <button type="button" class="btn btn-sm px-3 py-1.5 fw-bold view-btn active text-white" id="btnViewMonth" style="background-color: #046B26; border-color: #046B26;" onclick="switchView('month')">
                Month
              </button>
            </div>

          </div>

          {{-- Konten Utama Kalender (Bulan, Minggu, Hari) --}}
          <div class="card-body p-0" id="mainCalendarContent">
            
            {{-- VIEW BULAN (DEFAULT) --}}
            <div id="viewMonthContainer">
              
              {{-- Header Hari --}}
              <div class="row g-0 text-center fw-semibold text-muted py-2 border-bottom bg-light" style="font-size: 13px;">
                <div class="col" style="color: #dc3545;">Sun</div>
                <div class="col">Mon</div>
                <div class="col">Tue</div>
                <div class="col">Wed</div>
                <div class="col">Thu</div>
                <div class="col">Fri</div>
                <div class="col">Sat</div>
              </div>

              {{-- Grid Hari Bulan --}}
              <div class="calendar-month-grid" id="mainCalendarMonthGrid">
                <!-- Di-generate via JavaScript -->
              </div>
            </div>

            {{-- VIEW MINGGU --}}
            <div id="viewWeekContainer" class="d-none p-3">
              <div class="row g-2" id="weekGridDays">
                <!-- Di-generate via JavaScript -->
              </div>
            </div>

            {{-- VIEW HARI --}}
            <div id="viewDayContainer" class="d-none p-4">
              <div id="dayEventsContent">
                <!-- Di-generate via JavaScript -->
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>

{{-- MODAL DETAIL EVENT AKADEMIK --}}
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom py-3 px-4">
        <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="eventDetailModalLabel">
          <i class="bi bi-calendar-event text-success fs-5"></i>
          Detail Kegiatan Akademik
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="badge rounded-pill px-3 py-1.5 fw-bold" id="modalEventBadge">Kategori</span>
          <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1 small" id="modalEventSemester">Semester Ganjil</span>
        </div>

        <h5 class="fw-bold text-dark mb-3" id="modalEventTitle">Nama Kegiatan</h5>

        <div class="p-3 rounded-3 bg-light border mb-3">
          <div class="row g-2">
            <div class="col-12 d-flex align-items-center gap-2 text-muted small">
              <i class="bi bi-calendar2-range text-success"></i>
              <span>Tanggal: <strong class="text-dark" id="modalEventDate">01 - 15 Nov 2026</strong></span>
            </div>
            <div class="col-12 d-flex align-items-center gap-2 text-muted small mt-2">
              <i class="bi bi-info-circle text-primary"></i>
              <span>Keterangan: <span class="text-dark" id="modalEventDesc">-</span></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-top py-2 px-4">
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- CSS STYLES UNTUK FULLCALENDAR PERSIS SEPERTI GAMBAR --}}
<style>
.calendar-month-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background-color: #dee2e6;
  gap: 1px;
}

.calendar-day-cell {
  background-color: #ffffff;
  min-height: 115px;
  padding: 8px;
  position: relative;
  transition: background-color 0.15s ease;
  overflow: hidden;
}

.calendar-day-cell:hover {
  background-color: #fafbfc;
}

.calendar-day-cell.other-month {
  background-color: #fafbfd;
  color: #adb5bd;
}

.calendar-day-cell.is-today {
  background-color: #f0fdf4;
}

.day-number-badge {
  font-size: 13px;
  font-weight: 600;
  color: #374151;
  width: 24px;
  height: 24px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  margin-bottom: 4px;
}

.day-number-badge.today {
  background-color: #046B26;
  color: #ffffff;
  font-weight: 700;
}

.event-bar-pill {
  font-size: 11px;
  font-weight: 600;
  padding: 2.5px 7px;
  border-radius: 4px;
  margin-bottom: 3px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  cursor: pointer;
  transition: opacity 0.15s, transform 0.15s;
  display: block;
}

.event-bar-pill:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

.category-filter-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 6px 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.15s;
  font-size: 13px;
}

.category-filter-item:hover {
  background-color: #f1f5f9;
}

.category-filter-item.active {
  background-color: #f8fafc;
  font-weight: 600;
}

.upcoming-date-box {
  width: 44px;
  min-width: 44px;
  height: 44px;
  border-radius: 8px;
  background-color: #f1f5f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  line-height: 1;
}
</style>

{{-- JAVASCRIPT ENGINE FULLCALENDAR (PERSIS FITUR GAMBAR) --}}
<script>
const rawAgendaData = @json($agendaItems);

// Definisi Kategori & Warna Persis Referensi
const categoryConfigs = {
  'Perkuliahan': { color: '#10b981', textColor: '#ffffff', bgLight: '#d1fae5', label: 'Perkuliahan' },
  'Registrasi':   { color: '#3b82f6', textColor: '#ffffff', bgLight: '#dbeafe', label: 'Registrasi & KRS' },
  'Ujian':        { color: '#f59e0b', textColor: '#ffffff', bgLight: '#fef3c7', label: 'Ujian (UTS / UAS)' },
  'Libur':        { color: '#ef4444', textColor: '#ffffff', bgLight: '#fee2e2', label: 'Libur Semester' },
  'Wisuda':       { color: '#8b5cf6', textColor: '#ffffff', bgLight: '#ede9fe', label: 'Wisuda / Yudisium' },
  'Akademik':     { color: '#06b6d4', textColor: '#ffffff', bgLight: '#cffafe', label: 'Kegiatan Akademik' },
  'Kemahasiswaan': { color: '#ec4899', textColor: '#ffffff', bgLight: '#fce7f3', label: 'Kemahasiswaan' }
};

let currentView = 'month'; // 'month', 'week', 'day'
let activeDate = new Date(); // Date state
let activeCategoryFilters = new Set(Object.keys(categoryConfigs));

const monthNamesEng = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const monthNamesId = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
const dayNamesEng = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const dayNamesId = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

function init() {
  renderCategories();
  renderUpcomingEvents();
  renderMainCalendar();
}

// ─── CATEGORIES SIDEBAR ───
function renderCategories() {
  const container = document.getElementById('categoriesList');
  if (!container) return;
  container.innerHTML = '';

  Object.keys(categoryConfigs).forEach(catKey => {
    const conf = categoryConfigs[catKey];
    const count = rawAgendaData.filter(e => (e.kategori || 'Akademik') === catKey).length;
    const isChecked = activeCategoryFilters.has(catKey);

    const itemDiv = document.createElement('div');
    itemDiv.className = `category-filter-item ${isChecked ? 'active' : 'opacity-50'}`;
    itemDiv.onclick = () => toggleCategory(catKey);

    itemDiv.innerHTML = `
      <div class="d-flex align-items-center gap-2">
        <span class="rounded-1" style="width: 14px; height: 14px; background-color: ${conf.color}; display: inline-block;"></span>
        <span class="text-dark">${conf.label}</span>
      </div>
      <span class="badge bg-light text-muted rounded-pill small">${count}</span>
    `;

    container.appendChild(itemDiv);
  });
}

function toggleCategory(catKey) {
  if (activeCategoryFilters.has(catKey)) {
    if (activeCategoryFilters.size > 1) {
      activeCategoryFilters.delete(catKey);
    }
  } else {
    activeCategoryFilters.add(catKey);
  }
  renderCategories();
  renderMainCalendar();
}

function resetCategories() {
  activeCategoryFilters = new Set(Object.keys(categoryConfigs));
  renderCategories();
  renderMainCalendar();
}

// ─── UPCOMING EVENTS (SIDEBAR KIRI) ───
function renderUpcomingEvents() {
  const container = document.getElementById('upcomingEventsList');
  const countBadge = document.getElementById('upcomingCountBadge');
  if (!container) return;
  container.innerHTML = '';

  // Sort events by date
  const sorted = [...rawAgendaData].sort((a, b) => a.tanggal_mulai.localeCompare(b.tanggal_mulai));
  if (countBadge) countBadge.innerText = sorted.length;

  sorted.slice(0, 10).forEach(ev => {
    const conf = categoryConfigs[ev.kategori] || categoryConfigs['Akademik'];
    const parts = ev.tanggal_mulai.split('-');
    const day = parts[2] || '01';
    const monthEng = monthNamesEng[parseInt(parts[1] || '1', 10) - 1].substring(0, 3).toUpperCase();

    const item = document.createElement('div');
    item.className = 'd-flex align-items-center gap-2.5 p-2 rounded-3 border-0 bg-light';
    item.style.cursor = 'pointer';
    item.onclick = () => openEventModal(ev);

    item.innerHTML = `
      <div class="upcoming-date-box text-center shadow-xs" style="border-left: 3px solid ${conf.color};">
        <div class="fw-bolder fs-6 text-dark">${day}</div>
        <div class="text-muted fw-bold" style="font-size: 9px;">${monthEng}</div>
      </div>
      <div class="overflow-hidden">
        <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">${ev.kegiatan}</div>
        <div class="text-muted small" style="font-size: 11px;">${conf.label}</div>
      </div>
    `;

    container.appendChild(item);
  });
}

// ─── MAIN CALENDAR LOGIC (PERSIS TAMPILAN FULLCALENDAR BULAN) ───
function renderMainCalendar() {
  const y = activeDate.getFullYear();
  const m = activeDate.getMonth();
  const d = activeDate.getDate();

  // Header Title: Wednesday, November 25, 2026
  const titleEl = document.getElementById('mainCalendarTitle');
  if (titleEl) {
    if (currentView === 'month') {
      titleEl.innerText = `${dayNamesEng[activeDate.getDay()]}, ${monthNamesEng[m]} ${d}, ${y}`;
    } else if (currentView === 'week') {
      titleEl.innerText = `Week of ${monthNamesEng[m]} ${d}, ${y}`;
    } else {
      titleEl.innerText = `${dayNamesEng[activeDate.getDay()]}, ${monthNamesEng[m]} ${d}, ${y}`;
    }
  }

  if (currentView === 'month') {
    renderMonthView(y, m);
  } else if (currentView === 'week') {
    renderWeekView(y, m, d);
  } else {
    renderDayView(y, m, d);
  }
}

function renderMonthView(year, month) {
  document.getElementById('viewMonthContainer').classList.remove('d-none');
  document.getElementById('viewWeekContainer').classList.add('d-none');
  document.getElementById('viewDayContainer').classList.add('d-none');

  const grid = document.getElementById('mainCalendarMonthGrid');
  if (!grid) return;
  grid.innerHTML = '';

  const firstDay = new Date(year, month, 1).getDay(); // Sunday = 0
  const lastDay = new Date(year, month + 1, 0).getDate();
  const prevLastDay = new Date(year, month, 0).getDate();

  const today = new Date();

  // Previous month padding
  for (let i = firstDay; i > 0; i--) {
    const prevDate = prevLastDay - i + 1;
    const prevMonthIdx = month === 0 ? 11 : month - 1;
    const prevYear = month === 0 ? year - 1 : year;
    const cell = createDayCell(prevYear, prevMonthIdx, prevDate, true);
    grid.appendChild(cell);
  }

  // Current month days
  for (let d = 1; d <= lastDay; d++) {
    const cell = createDayCell(year, month, d, false);
    grid.appendChild(cell);
  }

  // Next month padding to fill complete rows of 7
  const currentTotal = firstDay + lastDay;
  const remaining = (7 - (currentTotal % 7)) % 7;
  const nextMonthIdx = month === 11 ? 0 : month + 1;
  const nextYear = month === 11 ? year + 1 : year;
  for (let n = 1; n <= remaining; n++) {
    const cell = createDayCell(nextYear, nextMonthIdx, n, true);
    grid.appendChild(cell);
  }
}

function createDayCell(y, m, d, isOtherMonth) {
  const cell = document.createElement('div');
  const dateStr = `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
  
  const today = new Date();
  const isToday = (today.getFullYear() === y && today.getMonth() === m && today.getDate() === d);

  cell.className = `calendar-day-cell ${isOtherMonth ? 'other-month' : ''} ${isToday ? 'is-today' : ''}`;

  // Day number badge
  const numberBadge = document.createElement('div');
  numberBadge.className = `day-number-badge ${isToday ? 'today' : ''}`;
  numberBadge.innerText = d;
  cell.appendChild(numberBadge);

  // Events on this day
  const events = rawAgendaData.filter(ev => {
    if (!activeCategoryFilters.has(ev.kategori || 'Akademik')) return false;
    return dateStr >= ev.tanggal_mulai && dateStr <= (ev.tanggal_selesai || ev.tanggal_mulai);
  });

  const maxVisible = 2;
  events.slice(0, maxVisible).forEach(ev => {
    const conf = categoryConfigs[ev.kategori] || categoryConfigs['Akademik'];
    const pill = document.createElement('div');
    pill.className = 'event-bar-pill text-truncate';
    pill.style.backgroundColor = conf.color;
    pill.style.color = conf.textColor;
    pill.innerText = ev.kegiatan;
    pill.title = `${ev.kegiatan} (${conf.label})`;
    pill.onclick = (e) => {
      e.stopPropagation();
      openEventModal(ev);
    };
    cell.appendChild(pill);
  });

  if (events.length > maxVisible) {
    const moreLink = document.createElement('div');
    moreLink.className = 'small text-muted fw-bold mt-1';
    moreLink.style.fontSize = '10px';
    moreLink.style.cursor = 'pointer';
    moreLink.innerText = `+${events.length - maxVisible} more`;
    moreLink.onclick = (e) => {
      e.stopPropagation();
      activeDate = new Date(y, m, d);
      switchView('day');
    };
    cell.appendChild(moreLink);
  }

  cell.onclick = () => {
    activeDate = new Date(y, m, d);
    if (events.length > 0) {
      openEventModal(events[0]);
    }
  };

  return cell;
}

// ─── WEEK VIEW ───
function renderWeekView(year, month, day) {
  document.getElementById('viewMonthContainer').classList.add('d-none');
  document.getElementById('viewWeekContainer').classList.remove('d-none');
  document.getElementById('viewDayContainer').classList.add('d-none');

  const container = document.getElementById('weekGridDays');
  if (!container) return;
  container.innerHTML = '';

  const targetDate = new Date(year, month, day);
  const dayOfWeek = targetDate.getDay();
  const startOfWeek = new Date(targetDate);
  startOfWeek.setDate(targetDate.getDate() - dayOfWeek);

  const today = new Date();

  for (let i = 0; i < 7; i++) {
    const current = new Date(startOfWeek);
    current.setDate(startOfWeek.getDate() + i);

    const cy = current.getFullYear();
    const cm = current.getMonth();
    const cd = current.getDate();
    const dateStr = `${cy}-${String(cm + 1).padStart(2, '0')}-${String(cd).padStart(2, '0')}`;
    const isToday = (today.getFullYear() === cy && today.getMonth() === cm && today.getDate() === cd);

    const events = rawAgendaData.filter(ev => {
      if (!activeCategoryFilters.has(ev.kategori || 'Akademik')) return false;
      return dateStr >= ev.tanggal_mulai && dateStr <= (ev.tanggal_selesai || ev.tanggal_mulai);
    });

    const col = document.createElement('div');
    col.className = 'col-md';
    col.innerHTML = `
      <div class="card h-100 border rounded-4 p-3 ${isToday ? 'bg-light border-success' : 'bg-white'}">
        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
          <span class="small fw-bold text-muted text-uppercase">${dayNamesEng[i].substring(0, 3)}</span>
          <span class="day-number-badge ${isToday ? 'today' : ''}">${cd}</span>
        </div>
        <div class="d-flex flex-column gap-1.5 overflow-auto" style="min-height: 220px;">
          ${events.length === 0 ? '<div class="text-muted small py-3 text-center">-</div>' : ''}
          ${events.map(ev => {
            const conf = categoryConfigs[ev.kategori] || categoryConfigs['Akademik'];
            return `
              <div class="event-bar-pill" style="background-color: ${conf.color}; color: ${conf.textColor};" onclick='openEventModal(${JSON.stringify(ev)})'>
                ${ev.kegiatan}
              </div>
            `;
          }).join('')}
        </div>
      </div>
    `;

    container.appendChild(col);
  }
}

// ─── DAY VIEW ───
function renderDayView(year, month, day) {
  document.getElementById('viewMonthContainer').classList.add('d-none');
  document.getElementById('viewWeekContainer').classList.add('d-none');
  document.getElementById('viewDayContainer').classList.remove('d-none');

  const container = document.getElementById('dayEventsContent');
  if (!container) return;
  container.innerHTML = '';

  const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
  const events = rawAgendaData.filter(ev => {
    if (!activeCategoryFilters.has(ev.kategori || 'Akademik')) return false;
    return dateStr >= ev.tanggal_mulai && dateStr <= (ev.tanggal_selesai || ev.tanggal_mulai);
  });

  const header = document.createElement('div');
  header.className = 'd-flex align-items-center justify-content-between pb-3 mb-4 border-bottom';
  header.innerHTML = `
    <div>
      <h5 class="fw-bold text-dark mb-0">${dayNamesId[activeDate.getDay()]}, ${day} ${monthNamesId[month]} ${year}</h5>
      <span class="text-muted small">Terdapat ${events.length} kegiatan akademik pada hari ini</span>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="switchView('month')">
      Kembali ke Tampilan Bulan
    </button>
  `;
  container.appendChild(header);

  if (events.length === 0) {
    container.innerHTML += `
      <div class="text-center py-5 text-muted bg-light rounded-4">
        <i class="bi bi-calendar-check fs-2 text-secondary d-block mb-2"></i>
        Tidak ada agenda akademik khusus pada tanggal ini.
      </div>
    `;
    return;
  }

  const list = document.createElement('div');
  list.className = 'd-flex flex-column gap-3';
  events.forEach(ev => {
    const conf = categoryConfigs[ev.kategori] || categoryConfigs['Akademik'];
    const item = document.createElement('div');
    item.className = 'p-3 rounded-4 border bg-white shadow-xs d-flex align-items-center justify-content-between gap-3';
    item.style.borderLeft = `5px solid ${conf.color} !important`;

    item.innerHTML = `
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="badge rounded-pill px-2.5 py-1" style="background-color: ${conf.bgLight}; color: ${conf.color};">
            ● ${conf.label}
          </span>
          <span class="badge bg-light text-muted border rounded-pill px-2 py-0.5 small">Semester ${ev.semester || 'Ganjil'}</span>
        </div>
        <h6 class="fw-bold text-dark mb-1" style="font-size: 16px;">${ev.kegiatan}</h6>
        <div class="text-muted small">${ev.keterangan || 'Jadwal resmi perkuliahan Universitas Ibnu Sina'}</div>
      </div>
      <div>
        <span class="badge bg-light text-dark border rounded-3 px-3 py-2 small fw-semibold">
          ${ev.tanggal_mulai} s/d ${ev.tanggal_selesai || ev.tanggal_mulai}
        </span>
      </div>
    `;
    list.appendChild(item);
  });

  container.appendChild(list);
}

// ─── NAVIGASI TOOLBAR ───
function mainPrev() {
  if (currentView === 'month') {
    activeDate.setMonth(activeDate.getMonth() - 1);
  } else if (currentView === 'week') {
    activeDate.setDate(activeDate.getDate() - 7);
  } else {
    activeDate.setDate(activeDate.getDate() - 1);
  }
  renderMainCalendar();
}

function mainNext() {
  if (currentView === 'month') {
    activeDate.setMonth(activeDate.getMonth() + 1);
  } else if (currentView === 'week') {
    activeDate.setDate(activeDate.getDate() + 7);
  } else {
    activeDate.setDate(activeDate.getDate() + 1);
  }
  renderMainCalendar();
}

function mainToday() {
  activeDate = new Date();
  renderMainCalendar();
}

function switchView(viewName) {
  currentView = viewName;

  document.querySelectorAll('.view-btn').forEach(b => {
    b.classList.remove('active', 'text-white');
    b.style.backgroundColor = '';
    b.style.borderColor = '';
  });

  const activeBtn = document.getElementById(`btnView${viewName.charAt(0).toUpperCase() + viewName.slice(1)}`);
  if (activeBtn) {
    activeBtn.classList.add('active', 'text-white');
    activeBtn.style.backgroundColor = '#046B26';
    activeBtn.style.borderColor = '#046B26';
  }

  renderMainCalendar();
}

// ─── MODAL DETAIL EVENT ───
function openEventModal(ev) {
  const conf = categoryConfigs[ev.kategori] || categoryConfigs['Akademik'];
  
  const modalBadge = document.getElementById('modalEventBadge');
  modalBadge.style.backgroundColor = conf.color;
  modalBadge.style.color = conf.textColor;
  modalBadge.innerText = conf.label;

  document.getElementById('modalEventSemester').innerText = `Semester ${ev.semester || 'Ganjil'}`;
  document.getElementById('modalEventTitle').innerText = ev.kegiatan;
  
  let dateText = ev.tanggal_mulai;
  if (ev.tanggal_selesai && ev.tanggal_selesai !== ev.tanggal_mulai) {
    dateText = `${ev.tanggal_mulai} s/d ${ev.tanggal_selesai}`;
  }
  document.getElementById('modalEventDate').innerText = dateText;
  document.getElementById('modalEventDesc').innerText = ev.keterangan || 'Agenda kegiatan resmi kalender akademik Universitas Ibnu Sina.';

  const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
  modal.show();
}

document.addEventListener('DOMContentLoaded', init);
</script>
@endsection
