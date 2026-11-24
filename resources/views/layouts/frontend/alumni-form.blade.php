@extends('layouts.frontend.template')

@section('title', 'Formulir Ulasan & Testimoni Alumni — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Portal khusus pengisian testimoni dan kisah sukses alumni serta civitas akademika Universitas Ibnu Sina.')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'alumni-create',
    'heroClass' => 'about-hero'
])

<!-- ═══════════════════════════════════════════════
     FORMULIR KHUSUS PENGISIAN TESTIMONI ALUMNI
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        
        <!-- Info Card Moderasi -->
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-3 p-4 mb-4" style="border-radius: 16px; background: #eef7ff; border-left: 5px solid #0088ff !important;">
          <i class="bi bi-shield-check fs-2 text-primary mt-1"></i>
          <div>
            <h6 class="fw-bold text-dark mb-1">Verifikasi & Moderasi Ulasan</h6>
            <p class="small text-muted mb-0">
              Formulir ini dikhususkan bagi alumni, mahasiswa, maupun mitra industri dan institusi Universitas Ibnu Sina. Setiap testimoni yang dikirimkan akan diverifikasi oleh admin sebelum ditampilkan di halaman website resmi demi menjaga validitas data.
            </p>
          </div>
        </div>

        <div class="card border-0 shadow-lg p-4 p-md-5" style="border-radius: 24px; background: var(--white); border: 1px solid #d8e8dc !important;">
          
          <div class="text-center mb-4">
            <div class="section-label mx-auto">Kisah Sukses Alumni</div>
            <h3 class="fw-bold mb-2 text-dark">Bagikan Jejak Karier & Pengalaman Anda</h3>
            <p class="text-muted small" style="max-width: 520px; margin: 0 auto;">
              Cerita dan pengalaman Anda akan sangat menginspirasi calon mahasiswa baru serta membanggakan almamater Universitas Ibnu Sina.
            </p>
          </div>

          @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 p-3" role="alert" style="border-radius: 12px;">
              <i class="bi bi-check-circle-fill me-3 fs-3 text-success"></i>
              <div>
                <strong>Berhasil Terkirim!</strong>
                <div class="small">{{ session('success') }}</div>
              </div>
            </div>
          @endif

          @if(isset($errors) && $errors->any())
            <div class="alert alert-danger mb-4" style="border-radius: 12px;">
              <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('homepage.alumni.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
              {{-- Nama Lengkap --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" placeholder="Contoh: Ns. Siti Rahma, S.Kep" value="{{ old('nama') }}" required style="border-radius: 12px; font-size: 14px;">
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Profesi / Pekerjaan --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Profesi / Jabatan / Tempat Bekerja <span class="text-danger">*</span></label>
                <input type="text" name="pekerjaan" class="form-control form-control-lg @error('pekerjaan') is-invalid @enderror" placeholder="Contoh: Perawat Klinis di RSUD Embung Fatimah" value="{{ old('pekerjaan') }}" required style="border-radius: 12px; font-size: 14px;">
                @error('pekerjaan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Kategori Hubungan --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Kategori Hubungan <span class="text-danger">*</span></label>
                @php
                  $kategoriOptions = ['Alumni', 'Mahasiswa', 'Mitra Rumah Sakit', 'Dosen & Staff', 'Industri / Perusahaan', 'Pengguna Lulusan / Stakeholder'];
                  $oldKategori = old('kategori', 'Alumni');
                  $isCustom = $oldKategori && !in_array($oldKategori, $kategoriOptions);
                @endphp
                <select id="kategoriSelect" name="_kategori_select" class="form-select form-select-lg @error('kategori') is-invalid @enderror" style="border-radius: 12px; font-size: 14px;" onchange="handleKategoriChange(this)">
                  <option value="" disabled {{ (!$oldKategori || $isCustom) ? '' : '' }}>-- Pilih Kategori --</option>
                  <option value="Alumni" {{ $oldKategori == 'Alumni' ? 'selected' : '' }}>Alumni UIS</option>
                  <option value="Mahasiswa" {{ $oldKategori == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa Aktif</option>
                  <option value="Mitra Industri" {{ $oldKategori == 'Mitra Industri' ? 'selected' : '' }}>Mitra Dunia Usaha & Industri (DUDI)</option>
                  <option value="Dosen & Staff" {{ $oldKategori == 'Dosen & Staff' ? 'selected' : '' }}>Dosen & Tenaga Kependidikan</option>
                  <option value="Industri / Perusahaan" {{ $oldKategori == 'Industri / Perusahaan' ? 'selected' : '' }}>Industri / Perusahaan</option>
                  <option value="Pengguna Lulusan / Stakeholder" {{ $oldKategori == 'Pengguna Lulusan / Stakeholder' ? 'selected' : '' }}>Pengguna Lulusan / Stakeholder</option>
                  <option value="__custom__" {{ $isCustom ? 'selected' : '' }}>✏️ Lainnya (Ketik Sendiri)</option>
                </select>
                {{-- Hidden actual value field --}}
                <input type="hidden" id="kategoriValue" name="kategori" value="{{ $isCustom ? $oldKategori : ($oldKategori ?: 'Alumni') }}">
                {{-- Custom input (shown when Lainnya selected) --}}
                <div id="kategoriCustomWrap" style="margin-top: 8px; display: {{ $isCustom ? 'block' : 'none' }};">
                  <input type="text" id="kategoriCustomInput" class="form-control form-control-lg" placeholder="Contoh: Manufaktur, BUMN, Perbankan, IT Konsultan..." value="{{ $isCustom ? $oldKategori : '' }}" style="border-radius: 12px; font-size: 14px; border-color: #046B26;" oninput="document.getElementById('kategoriValue').value = this.value">
                  <div class="small text-muted mt-1"><i class="bi bi-info-circle me-1"></i>Tuliskan kategori Anda secara spesifik.</div>
                </div>
                @error('kategori')
                  <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                @enderror
              </div>

              {{-- Rating Bintang --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Tingkat Kepuasan (Rating) <span class="text-danger">*</span></label>
                <select name="bintang" class="form-select form-select-lg @error('bintang') is-invalid @enderror" required style="border-radius: 12px; font-size: 14px;">
                  <option value="5" {{ old('bintang', 5) == 5 ? 'selected' : '' }}>★★★★★ (5 Bintang - Sangat Puas)</option>
                  <option value="4" {{ old('bintang') == 4 ? 'selected' : '' }}>★★★★☆ (4 Bintang - Puas)</option>
                  <option value="3" {{ old('bintang') == 3 ? 'selected' : '' }}>★★★☆☆ (3 Bintang - Cukup)</option>
                  <option value="2" {{ old('bintang') == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Bintang - Kurang)</option>
                  <option value="1" {{ old('bintang') == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Bintang - Sangat Kurang)</option>
                </select>
                @error('bintang')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Pesan Ulasan --}}
              <div class="col-12">
                <label class="form-label fw-semibold text-dark">Pesan, Ulasan & Testimoni Anda <span class="text-danger">*</span></label>
                <textarea name="pesan" rows="5" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tuliskan pengalaman belajar, suasana perkuliahan di Universitas Ibnu Sina, bimbingan para dosen, laboratorium, atau kemudahan berkarir setelah lulus..." required style="border-radius: 12px; font-size: 14px;">{{ old('pesan') }}</textarea>
                @error('pesan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Honeypot Trap (Tersembunyi dari Pengguna Nyata untuk Menjebak Bot Spammer Otomatis) --}}
              <div style="display:none !important;" aria-hidden="true">
                <input type="text" name="website_trap" tabindex="-1" autocomplete="off">
              </div>

              {{-- Verifikasi Keamanan Captcha Anti-Spam --}}
              <div class="col-12">
                <div class="p-3.5 p-md-4 rounded-4 bg-light border" style="border-color: #d1e7dd !important;">
                  <label class="form-label fw-semibold text-dark mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <span class="d-inline-flex align-items-center">
                      <i class="bi bi-shield-lock-fill text-success fs-5 me-2"></i>
                      <span>Verifikasi Keamanan (Captcha Anti-Spam) <span class="text-danger">*</span></span>
                    </span>
                    <span class="small text-muted fw-normal">Selesaikan penjumlahan angka</span>
                  </label>
                  
                  <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="py-2 px-3 rounded-3 bg-white border text-dark fw-bold d-inline-flex align-items-center gap-2 shadow-xs" style="font-size: 16px; user-select: none;">
                      <span id="captchaDisplay" class="font-monospace text-success fw-bold" style="letter-spacing: 2px;">
                        {{ session('alumni_captcha_num1', 7) }} + {{ session('alumni_captcha_num2', 5) }} = ?
                      </span>
                      <button type="button" class="btn btn-sm btn-link p-0 text-success ms-2" onclick="refreshCaptcha()" title="Ganti Angka Captcha">
                        <i class="bi bi-arrow-clockwise fs-5"></i>
                      </button>
                    </div>

                    <div style="max-width: 200px; flex: 1 1 140px;">
                      <input type="number" name="captcha" id="captchaInput" class="form-control form-control-lg @error('captcha') is-invalid @enderror" placeholder="Tulis jawaban..." required style="border-radius: 12px; font-size: 14px;">
                    </div>
                  </div>

                  @error('captcha')
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                  @enderror
                  <div class="small text-muted mt-2">
                    <i class="bi bi-info-circle me-1"></i>Fitur ini melindungi sistem dari pengiriman formulir otomatis/spam.
                  </div>
                </div>
              </div>

              {{-- Tombol Kirim --}}
              <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-primary-hero px-5 py-3 shadow" style="cursor: pointer; border-radius: 30px; font-size: 15px;">
                  <i class="bi bi-send-fill me-2"></i> Kirim Testimoni Saya
                </button>
              </div>

            </div>
          </form>

          <div class="text-center mt-4 pt-3 border-top" style="border-color: #f2e9f7 !important;">
            <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Login Portal
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  function handleKategoriChange(selectEl) {
    const val = selectEl.value;
    const hiddenInput  = document.getElementById('kategoriValue');
    const customWrap   = document.getElementById('kategoriCustomWrap');
    const customInput  = document.getElementById('kategoriCustomInput');

    if (val === '__custom__') {
      customWrap.style.display = 'block';
      customInput.focus();
      hiddenInput.value = customInput.value || '';
    } else {
      customWrap.style.display = 'none';
      customInput.value = '';
      hiddenInput.value = val;
    }
  }

  function refreshCaptcha() {
    const display = document.getElementById('captchaDisplay');
    if (!display) return;
    display.innerHTML = '<span class="spinner-border spinner-border-sm text-success" role="status"></span>';
    
    fetch('{{ route("homepage.alumni.captcha-refresh") }}')
      .then(res => res.json())
      .then(data => {
        display.textContent = data.question;
        const input = document.getElementById('captchaInput');
        if (input) {
          input.value = '';
          input.focus();
        }
      })
      .catch(() => {
        display.textContent = '7 + 5 = ?';
      });
  }

  // Sync on page load (for validation errors)
  document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('kategoriSelect');
    if (sel) handleKategoriChange(sel);
  });
</script>
@endpush
