@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h1 class="mb-1">Kelola Galeri Brosur & Poster PMB</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pmb.index') }}">PMB</a></li>
                    <li class="breadcrumb-item active">Brosur & Poster</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('homepage.pmb-brosur') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Galeri Publik
            </a>
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBrosur" style="background-color: #046B26; border-color: #046B26;">
                <i class="bi bi-plus-circle me-1"></i> Tambah Brosur / Poster
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan pada formulir:</div>
        <ul class="mb-0 ps-3 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
    <div class="card-header bg-white py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom">
        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2" style="font-size: 16px;">
            <i class="bi bi-images text-success fs-5"></i>
            Daftar Brosur & Poster Antar-Fakultas UIS
        </h5>
        <span class="badge bg-light text-muted border rounded-pill px-3 py-1.5 small fw-semibold">
            Galeri Terintegrasi Semua Fakultas
        </span>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH BROSUR --}}
<div class="modal fade" id="modalTambahBrosur" tabindex="-1" aria-labelledby="modalTambahBrosurLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-white py-3 px-4 border-bottom">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="modalTambahBrosurLabel">
                    <i class="bi bi-plus-circle-fill text-success fs-5"></i>
                    Tambah Brosur / Poster PMB Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.pmb.brosur.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="create_judul" class="form-label fw-bold text-dark small">
                                Judul Brosur / Poster <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="create_judul" name="judul" class="form-control rounded-3" 
                                   placeholder="Contoh: Brosur PMB Fakultas Sains & Teknologi TA 2026/2027" required>
                        </div>
                        <div class="col-md-4">
                            <label for="create_tahun" class="form-label fw-bold text-dark small">Tahun Akademik</label>
                            <input type="text" id="create_tahun" name="tahun_akademik" class="form-control rounded-3" 
                                   value="2026/2027" placeholder="Contoh: 2026/2027">
                        </div>

                        <div class="col-md-8">
                            <label for="create_kategori" class="form-label fw-bold text-dark small">
                                Kategori / Fakultas <span class="text-danger">*</span>
                            </label>
                            <select id="create_kategori" name="kategori_fakultas" class="form-select rounded-3" required>
                                @foreach($fakultasOptions as $f)
                                    <option value="{{ $f }}" {{ $f === 'Universitas' ? 'selected' : '' }}>
                                        {{ $f === 'Universitas' ? 'Universitas (Umum / Institusi)' : $f }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted small">Pilih fakultas pemilik brosur untuk memudahkan filter di halaman galeri.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="create_urutan" class="form-label fw-bold text-dark small">Urutan Tampil</label>
                            <input type="number" id="create_urutan" name="urutan" class="form-control rounded-3" value="0" min="0">
                        </div>

                        <div class="col-md-6">
                            <label for="create_gambar" class="form-label fw-bold text-dark small">
                                File Gambar Poster / Brosur <span class="text-danger">*</span>
                            </label>
                            <input type="file" id="create_gambar" name="gambar" class="form-control rounded-3" 
                                   accept="image/jpeg,image/png,image/webp" required>
                            <div class="form-text text-muted small">Format: JPG, PNG, WEBP. Maks. 10 MB. Resolusi tinggi disarankan.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="create_pdf" class="form-label fw-bold text-dark small">
                                File Dokumen PDF Brosur <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <input type="file" id="create_pdf" name="file_pdf" class="form-control rounded-3" accept=".pdf">
                            <div class="form-text text-muted small">Jika ada salinan PDF lengkap brosur (Maksimal 20 MB).</div>
                        </div>

                        <div class="col-12">
                            <label for="create_deskripsi" class="form-label fw-bold text-dark small">Keterangan / Deskripsi Singkat</label>
                            <textarea id="create_deskripsi" name="deskripsi" class="form-control rounded-3" rows="3" 
                                      placeholder="Keterangan singkat tentang program studi, rincian beasiswa, atau informasi yang termuat pada brosur ini..."></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" role="switch" id="create_is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-semibold text-dark small" for="create_is_active">
                                    Publikasikan di Galeri Frontend (Aktif)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2.5 px-4 border-top">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold" style="background-color: #046B26; border-color: #046B26;">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan & Unggah Brosur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT BROSUR --}}
<div class="modal fade" id="modalEditBrosur" tabindex="-1" aria-labelledby="modalEditBrosurLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-white py-3 px-4 border-bottom">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="modalEditBrosurLabel">
                    <i class="bi bi-pencil-square text-warning fs-5"></i>
                    Sunting Brosur / Poster PMB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditBrosur" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="edit_judul" class="form-label fw-bold text-dark small">
                                Judul Brosur / Poster <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="edit_judul" name="judul" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_tahun" class="form-label fw-bold text-dark small">Tahun Akademik</label>
                            <input type="text" id="edit_tahun" name="tahun_akademik" class="form-control rounded-3">
                        </div>

                        <div class="col-md-8">
                            <label for="edit_kategori" class="form-label fw-bold text-dark small">
                                Kategori / Fakultas <span class="text-danger">*</span>
                            </label>
                            <select id="edit_kategori" name="kategori_fakultas" class="form-select rounded-3" required>
                                @foreach($fakultasOptions as $f)
                                    <option value="{{ $f }}">
                                        {{ $f === 'Universitas' ? 'Universitas (Umum / Institusi)' : $f }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_urutan" class="form-label fw-bold text-dark small">Urutan Tampil</label>
                            <input type="number" id="edit_urutan" name="urutan" class="form-control rounded-3" min="0">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_gambar" class="form-label fw-bold text-dark small">
                                Ganti Gambar Poster <span class="text-muted fw-normal">(Kosongkan jika tidak diganti)</span>
                            </label>
                            <input type="file" id="edit_gambar" name="gambar" class="form-control rounded-3" 
                                   accept="image/jpeg,image/png,image/webp">
                            <div class="mt-2" id="edit_preview_container">
                                <span class="text-muted small d-block mb-1">Pratinjau gambar saat ini:</span>
                                <a id="edit_gambar_link" href="#" target="_blank">
                                    <img id="edit_gambar_img" src="#" alt="Poster" class="rounded border shadow-sm" style="max-height: 120px; object-fit: contain;">
                                </a>
                                <div class="small text-muted mt-1" id="edit_gambar_filename" style="font-size: 11.5px;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_pdf" class="form-label fw-bold text-dark small">
                                Ganti Dokumen PDF <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <input type="file" id="edit_pdf" name="file_pdf" class="form-control rounded-3" accept=".pdf">
                            <div class="mt-2" id="edit_pdf_container">
                                <span class="text-muted small d-block mb-1">Status PDF saat ini:</span>
                                <div id="edit_pdf_info"></div>
                                <div class="form-check mt-1" id="edit_hapus_pdf_wrapper">
                                    <input class="form-check-input" type="checkbox" id="edit_hapus_pdf" name="hapus_pdf" value="1">
                                    <label class="form-check-label text-danger small fw-semibold" for="edit_hapus_pdf">
                                        <i class="bi bi-trash me-1"></i> Hapus berkas PDF ini
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="edit_deskripsi" class="form-label fw-bold text-dark small">Keterangan / Deskripsi Singkat</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control rounded-3" rows="3"></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label fw-semibold text-dark small" for="edit_is_active">
                                    Publikasikan di Galeri Frontend (Aktif)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2.5 px-4 border-top">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold" style="background-color: #046B26; border-color: #046B26;">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan Brosur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event delegation untuk tombol edit brosur
        $(document).on('click', '.btn-edit-brosur', function () {
            const btn = $(this);
            const form = $('#formEditBrosur');

            form.attr('action', btn.data('update-url'));
            $('#edit_judul').val(btn.data('judul'));
            $('#edit_kategori').val(btn.data('kategori'));
            $('#edit_tahun').val(btn.data('tahun'));
            $('#edit_urutan').val(btn.data('urutan'));
            $('#edit_deskripsi').val(btn.data('deskripsi'));

            const isActive = String(btn.data('active')) === '1';
            $('#edit_is_active').prop('checked', isActive);

            // Pratinjau Gambar
            const gambarUrl = btn.data('gambar-url');
            const namaAsli = btn.data('nama-asli');
            if (gambarUrl) {
                $('#edit_gambar_img').attr('src', gambarUrl);
                $('#edit_gambar_link').attr('href', gambarUrl);
                if (namaAsli) {
                    $('#edit_gambar_filename').html('<i class="bi bi-file-earmark-image me-1 text-success"></i> Nama File: <strong>' + namaAsli + '</strong>');
                } else {
                    $('#edit_gambar_filename').empty();
                }
                $('#edit_preview_container').show();
            } else {
                $('#edit_preview_container').hide();
            }

            // Status PDF
            const pdfUrl = btn.data('pdf-url');
            const namaPdf = btn.data('nama-pdf');
            if (pdfUrl) {
                $('#edit_pdf_info').html(`
                    <a href="${pdfUrl}" target="_blank" class="btn btn-sm btn-outline-danger py-1 px-3 rounded-pill small fw-semibold">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> ${namaPdf || 'Buka PDF Tersimpan'}
                    </a>
                `);
                $('#edit_hapus_pdf_wrapper').show();
            } else {
                $('#edit_pdf_info').html('<span class="text-muted small fst-italic">Belum ada file PDF.</span>');
                $('#edit_hapus_pdf_wrapper').hide();
            }
            $('#edit_hapus_pdf').prop('checked', false);

            const modal = new bootstrap.Modal(document.getElementById('modalEditBrosur'));
            modal.show();
        });
    });
    </script>
@endpush
