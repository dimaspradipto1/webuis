@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Daftar Kerjasama</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra Kerjasama</a></li>
            <li class="breadcrumb-item active">{{ $partner->nama }}</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold"><i class="bi bi-file-earmark-check me-2 text-success"></i>{{ $partner->nama }}</h5>
            <span class="text-muted small">Kelola data program kerjasama MOU, MOA, dan IA untuk mitra ini.</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('partner.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Daftar Mitra
            </a>
            <a href="{{ route('partner.agreements.create', $partner) }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-lg me-1"></i>Tambah Kerjasama
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($agreements->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Jenis</th>
                            <th>Judul Kerjasama</th>
                            <th>Nomor Dokumen</th>
                            <th>Masa Berlaku</th>
                            <th>Ruang Lingkup</th>
                            <th>Status</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agreements as $index => $agreement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge rounded-pill text-bg-success">{{ $agreement->jenis }}</span>
                                </td>
                                <td class="fw-semibold">{{ $agreement->judul }}</td>
                                <td>{{ $agreement->nomor ?: '—' }}</td>
                                <td>
                                    @if($agreement->tanggal_mulai)
                                        {{ $agreement->tanggal_mulai->translatedFormat('d M Y') }}
                                        @if($agreement->tanggal_selesai)
                                            <br><small class="text-muted">s.d. {{ $agreement->tanggal_selesai->translatedFormat('d M Y') }}</small>
                                        @endif
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if($agreement->deskripsi)
                                        <small class="text-secondary">{{ Str::limit($agreement->deskripsi, 60) }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $agreement->aktif ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $agreement->aktif ? 'Tampil' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('partner.agreements.edit', [$partner, $agreement]) }}"
                                           class="btn btn-sm btn-warning text-white" title="Edit" aria-label="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('partner.agreements.destroy', [$partner, $agreement]) }}"
                                              method="POST" onsubmit="return confirm('Hapus data kerjasama ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus" aria-label="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3 text-success"><i class="bi bi-folder2-open" style="font-size:42px"></i></div>
                <h5 class="fw-bold">Belum ada data kerjasama</h5>
                <p class="text-muted mb-3">Tambahkan data kerjasama MOU, MOA, atau IA untuk {{ $partner->nama }}.</p>
                <a href="{{ route('partner.agreements.create', $partner) }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Kerjasama Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
