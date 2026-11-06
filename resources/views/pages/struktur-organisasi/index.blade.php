@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Profil dan Struktur Pimpinan</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil dan Struktur Pimpinan</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('homepage.struktur-organisasi') }}" target="_blank" class="btn btn-outline-success rounded-3 px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Depan
        </a>
        <a href="{{ route('struktur-organisasi.create') }}" class="btn btn-success rounded-3 px-3 shadow-sm" style="background: #046B26; border-color: #046B26;">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Kartu Pimpinan
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Periksa kembali inputan Anda:</strong>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════════════
     BAGIAN 1: KARTU PROFIL PIMPINAN UTAMA & HALAMAN DETAIL
══════════════════════════════════════════════════════════════════ --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-person-badge-fill text-success me-2"></i>1. Kartu Profil Pimpinan Utama (Dengan Halaman Detail)
            </h5>
            <small class="text-muted">Menampilkan foto pimpinan beserta tombol "Detail" untuk membuka halaman biografi lengkap pimpinan.</small>
        </div>
        <a href="{{ route('struktur-organisasi.create') }}" class="btn btn-sm btn-success rounded-pill px-3" style="background: #046B26; border-color: #046B26;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pimpinan
        </a>
    </div>

    <div class="card-body p-4">
        @php
            $barisLabels = [
                1 => 'Baris 1 — Ketua Yayasan & Rektor',
                2 => 'Baris 2 — Jajaran Wakil Rektor',
                3 => 'Baris 3 — Jajaran Dekan Fakultas',
            ];
        @endphp

        @foreach($barisLabels as $barisNum => $barisTitle)
            @php
                $items = $pimpinansByBaris->get($barisNum, collect());
            @endphp
            <div class="mb-4 last-mb-0">
                <div class="d-flex align-items-center justify-content-between bg-light rounded-3 px-3 py-2 mb-3 border">
                    <span class="fw-bold text-dark small">
                        <i class="bi bi-layers-fill text-success me-1"></i> {{ $barisTitle }} ({{ $items->count() }} Pimpinan)
                    </span>
                    <a href="{{ route('struktur-organisasi.create', ['baris' => $barisNum]) }}" class="btn btn-sm btn-link text-success text-decoration-none p-0 fw-semibold">
                        <i class="bi bi-plus-circle me-1"></i>Tambah di Baris {{ $barisNum }}
                    </a>
                </div>

                <div class="row g-3">
                    @forelse($items as $pimpinan)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="border rounded-4 p-3 h-100 d-flex flex-column justify-content-between bg-white shadow-xs text-center">
                                <div>
                                    <div class="position-relative d-inline-block mb-2">
                                        <img src="{{ $pimpinan->foto_url }}"
                                             alt="{{ $pimpinan->nama }}"
                                             class="rounded-3 border shadow-xs"
                                             style="width: 130px; height: 170px; object-fit: cover;">
                                        <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill {{ $pimpinan->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size: 10px;">
                                            {{ $pimpinan->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px; line-height: 1.35;">{{ $pimpinan->nama }}</h6>
                                    <p class="text-muted small mb-2" style="font-size: 12px; line-height: 1.4;">{{ $pimpinan->jabatan }}</p>
                                    <p class="text-secondary small mb-3" style="font-size: 11.5px;">
                                        @if(!empty($pimpinan->biografi))
                                            <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Biografi Detail Terisi</span>
                                        @else
                                            <span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Biografi Belum Diisi</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="d-flex justify-content-center gap-1 pt-2 border-top">
                                    <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3" title="Lihat Halaman Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('struktur-organisasi.edit', $pimpinan->id) }}" class="btn btn-sm btn-success rounded-3 flex-grow-1" style="background: #046B26; border-color: #046B26;">
                                        <i class="bi bi-pencil-square me-1"></i> Edit & Detail
                                    </a>
                                    <form action="{{ route('struktur-organisasi.destroy', $pimpinan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus profil {{ addslashes($pimpinan->nama) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-muted small py-2 ps-2">Belum ada pimpinan pada baris ini.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════
     BAGIAN 2: TABEL PIMPINAN DAN MANAJEMEN (REKTORAT, FEB, FST, FIKES)
══════════════════════════════════════════════════════════════════ --}}
<div class="card border-0 shadow-sm rounded-4 mb-4" id="section-manajemen">
    <div class="card-header bg-white py-3 px-4" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="bi bi-folder2-open text-success me-2"></i>2. Tabel Pimpinan dan Manajemen (Rektorat, FEB, FST, FIKES)
        </h5>
        <small class="text-muted">Kelola daftar nama dan jabatan struktural pada 4 tab (Rektorat, FEB, FST, FIKES).</small>
    </div>

    <div class="card-body p-4">
        {{-- Form Tambah Data Baru --}}
        <form action="{{ route('struktur-organisasi.manajemen.store') }}" method="POST" class="p-3 rounded-4 border bg-light mb-4">
            @csrf
            <div class="fw-bold small text-success mb-2">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Baris Pimpinan & Manajemen Baru
            </div>
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small fw-bold mb-1">Kategori Tab</label>
                    <select name="kategori" class="form-select form-select-sm" id="addManajemenKategori" required>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ $activeKategori === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label small fw-bold mb-1">No</label>
                    <input type="number" name="no_urut" class="form-control form-control-sm" placeholder="Auto" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control form-control-sm" placeholder="Contoh: Dr. Sudianto, SE., M.Si" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold mb-1">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control form-control-sm" placeholder="Contoh: Ka. Senat Universitas Ibnu Sina" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-success w-100 fw-semibold" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Data
                    </button>
                </div>
            </div>
        </form>

        {{-- 4 Filter Tabs --}}
        <div class="nav nav-pills gap-2 mb-3">
            @foreach($kategoriList as $kat)
                @php
                    $cnt = $manajemensAll->get($kat, collect())->count();
                    $isCurrent = $activeKategori === $kat;
                @endphp
                <button type="button"
                        class="nav-link rounded-pill px-4 py-2 fw-bold admin-manajemen-tab {{ $isCurrent ? 'active text-white' : 'bg-light text-dark border' }}"
                        style="{{ $isCurrent ? 'background: #046B26;' : '' }}"
                        data-kat="{{ $kat }}"
                        onclick="switchAdminManajemenTab('{{ $kat }}', this)">
                    {{ $kat }}
                    <span class="badge rounded-pill ms-1 {{ $isCurrent ? 'bg-white text-success' : 'bg-secondary text-white' }}">{{ $cnt }}</span>
                </button>
            @endforeach
        </div>

        {{-- Tabel per Kategori --}}
        @foreach($kategoriList as $kat)
            @php
                $rows = $manajemensAll->get($kat, collect());
                $isCurrent = $activeKategori === $kat;
            @endphp
            <div id="admin-pane-{{ $kat }}" class="admin-manajemen-pane {{ $isCurrent ? '' : 'd-none' }}">
                <div class="table-responsive border rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 75px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th class="text-end" style="width: 170px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $mRow)
                                <tr>
                                    <td class="fw-bold">{{ $mRow->no_urut }}</td>
                                    <td class="fw-semibold text-dark">{{ $mRow->nama }}</td>
                                    <td>{{ $mRow->jabatan }}</td>
                                    <td class="text-end">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-success rounded-2"
                                                onclick="openEditManajemenModal({{ $mRow->id }}, '{{ $mRow->kategori }}', {{ $mRow->no_urut }}, '{{ addslashes($mRow->nama) }}', '{{ addslashes($mRow->jabatan) }}')">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="{{ route('struktur-organisasi.manajemen.destroy', $mRow->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus {{ addslashes($mRow->nama) }} dari daftar {{ $mRow->kategori }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data pada tab {{ $kat }}.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Modal Edit Baris Manajemen --}}
<div class="modal fade" id="editManajemenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="editManajemenForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Edit Data Pimpinan & Manajemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold">Kategori Tab</label>
                            <select name="kategori" id="editManajemenKategori" class="form-select" required>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Nomor Urut</label>
                            <input type="number" name="no_urut" id="editManajemenNo" class="form-control" min="1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" id="editManajemenNama" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" id="editManajemenJabatan" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 px-4" style="background: #046B26; border-color: #046B26;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchAdminManajemenTab(kat, btn) {
        document.querySelectorAll('.admin-manajemen-pane').forEach(el => el.classList.add('d-none'));
        const pane = document.getElementById('admin-pane-' + kat);
        if (pane) pane.classList.remove('d-none');

        document.querySelectorAll('.admin-manajemen-tab').forEach(b => {
            b.classList.remove('active', 'text-white');
            b.classList.add('bg-light', 'text-dark', 'border');
            b.style.background = '';
        });

        if (btn) {
            btn.classList.add('active', 'text-white');
            btn.classList.remove('bg-light', 'text-dark', 'border');
            btn.style.background = '#046B26';
        }

        const selectAdd = document.getElementById('addManajemenKategori');
        if (selectAdd) selectAdd.value = kat;
    }

    function openEditManajemenModal(id, kategori, noUrut, nama, jabatan) {
        const form = document.getElementById('editManajemenForm');
        form.action = "{{ url('struktur-organisasi/manajemen') }}/" + id;
        document.getElementById('editManajemenKategori').value = kategori;
        document.getElementById('editManajemenNo').value = noUrut;
        document.getElementById('editManajemenNama').value = nama;
        document.getElementById('editManajemenJabatan').value = jabatan;

        const modal = new bootstrap.Modal(document.getElementById('editManajemenModal'));
        modal.show();
    }
</script>
@endpush
