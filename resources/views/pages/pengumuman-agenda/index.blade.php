@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Manajemen Pengumuman & Agenda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Informasi</li>
            <li class="breadcrumb-item active">Pengumuman & Agenda</li>
        </ol>
    </nav>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- ═══════════════════════════════════════════════
         1. DAFTAR PENGUMUMAN
    ═══════════════════════════════════════════════ -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-megaphone-fill me-2 text-success"></i>Daftar Pengumuman
                </h5>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddPengumuman">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pengumuman
                </button>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Judul Pengumuman</th>
                                <th style="width: 180px;">Tanggal</th>
                                <th style="width: 220px;">Tautan / URL</th>
                                <th class="text-center" style="width: 90px;">Urutan</th>
                                <th class="text-center" style="width: 100px;">Status</th>
                                <th class="text-center" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumumans as $idx => $item)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="fw-semibold">{{ $item->judul }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->waktu }}</span></td>
                                    <td>
                                        @if(!empty($item->url))
                                            <a href="{{ $item->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                                {{ $item->url }}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->urutan }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button"
                                                    class="btn btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditItem{{ $item->id }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('pengumuman-agenda.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data pengumuman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         2. DAFTAR AGENDA
    ═══════════════════════════════════════════════ -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-calendar4-week me-2 text-warning"></i>Daftar Agenda Akademik / Kampus
                </h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddAgenda">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Agenda
                </button>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th style="width: 240px;">Rentang Tanggal / Waktu</th>
                                <th>Judul Kegiatan / Agenda</th>
                                <th style="width: 220px;">Tautan / URL</th>
                                <th class="text-center" style="width: 90px;">Urutan</th>
                                <th class="text-center" style="width: 100px;">Status</th>
                                <th class="text-center" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $idx => $item)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="fw-semibold text-dark">{{ $item->waktu }}</td>
                                    <td>
                                        <span class="px-3 py-1 rounded-2 fw-semibold d-inline-block" style="background: #f4d348; color: #1a202c;">
                                            {{ $item->judul }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!empty($item->url))
                                            <a href="{{ $item->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                                {{ $item->url }}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->urutan }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button"
                                                    class="btn btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditItem{{ $item->id }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('pengumuman-agenda.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data agenda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════
     MODAL TAMBAH PENGUMUMAN
═══════════════════════════════════════════════ -->
<div class="modal fade" id="modalAddPengumuman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pengumuman-agenda.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="tipe" value="pengumuman">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-megaphone-fill me-2 text-success"></i>Tambah Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                    <textarea name="judul" rows="2" class="form-control" required placeholder="Contoh: Pengumuman Pengisian KRS dan validasi KRS Tahun Akademik 2026/2027 Gasal"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Pengumuman <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control" required placeholder="Contoh: 15 August 2026">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tautan / URL (Opsional)</label>
                    <input type="text" name="url" class="form-control" placeholder="https://... atau kosongkan">
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="{{ ($pengumumans->max('urutan') ?? 0) + 1 }}" min="0">
                    </div>
                    <div class="col-6 pt-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="addPengumumanActive" checked>
                            <label class="form-check-label fw-semibold" for="addPengumumanActive">Tampilkan (Aktif)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════
     MODAL TAMBAH AGENDA
═══════════════════════════════════════════════ -->
<div class="modal fade" id="modalAddAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pengumuman-agenda.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="tipe" value="agenda">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar4-week me-2 text-warning"></i>Tambah Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Rentang Tanggal / Waktu <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control" required placeholder="Contoh: 20 - 31 Juli 2026">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kegiatan / Agenda <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required placeholder="Contoh: Pendaftaran Semester Antara">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tautan / URL (Opsional)</label>
                    <input type="text" name="url" class="form-control" placeholder="https://... atau kosongkan">
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="{{ ($agendas->max('urutan') ?? 0) + 1 }}" min="0">
                    </div>
                    <div class="col-6 pt-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="addAgendaActive" checked>
                            <label class="form-check-label fw-semibold" for="addAgendaActive">Tampilkan (Aktif)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Agenda</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════
     MODAL EDIT UNTUK SETIAP ITEM
═══════════════════════════════════════════════ -->
@foreach($pengumumans->concat($agendas) as $item)
<div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pengumuman-agenda.update', $item->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit {{ $item->tipe === 'agenda' ? 'Agenda' : 'Pengumuman' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori Item</label>
                    <select name="tipe" class="form-select">
                        <option value="pengumuman" {{ $item->tipe === 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="agenda" {{ $item->tipe === 'agenda' ? 'selected' : '' }}>Agenda</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ $item->tipe === 'agenda' ? 'Rentang Tanggal / Waktu' : 'Tanggal Pengumuman' }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="waktu" class="form-control" value="{{ $item->waktu }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ $item->tipe === 'agenda' ? 'Nama Kegiatan / Agenda' : 'Judul Pengumuman' }} <span class="text-danger">*</span>
                    </label>
                    <textarea name="judul" rows="2" class="form-control" required>{{ $item->judul }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tautan / URL (Opsional)</label>
                    <input type="text" name="url" class="form-control" value="{{ $item->url }}" placeholder="https://... atau kosongkan">
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="{{ $item->urutan }}" min="0">
                    </div>
                    <div class="col-6 pt-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editActive{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="editActive{{ $item->id }}">Tampilkan (Aktif)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection

