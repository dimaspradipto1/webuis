<div class="row g-3">
    <div class="col-md-4">
        <label for="jenis" class="form-label fw-semibold">Jenis Dokumen <span class="text-danger">*</span></label>
        <select id="jenis" name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
            @foreach(\App\Models\PartnerAgreement::TYPES as $type)
                <option value="{{ $type }}" {{ old('jenis', $agreement->jenis ?: 'MOU') === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label for="judul" class="form-label fw-semibold">Judul Kerjasama <span class="text-danger">*</span></label>
        <input id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror"
               value="{{ old('judul', $agreement->judul) }}" maxlength="255" required
               placeholder="Contoh: Kolaborasi pendidikan dan penelitian">
        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="nomor" class="form-label fw-semibold">Nomor Dokumen</label>
        <input id="nomor" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
               value="{{ old('nomor', $agreement->nomor) }}" maxlength="255" placeholder="Opsional">
        @error('nomor')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
               class="form-control @error('tanggal_mulai') is-invalid @enderror"
               value="{{ old('tanggal_mulai', $agreement->tanggal_mulai?->format('Y-m-d')) }}">
        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
               class="form-control @error('tanggal_selesai') is-invalid @enderror"
               value="{{ old('tanggal_selesai', $agreement->tanggal_selesai?->format('Y-m-d')) }}">
        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="deskripsi" class="form-label fw-semibold">Ringkasan Kerjasama</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
                  class="form-control @error('deskripsi') is-invalid @enderror"
                  maxlength="10000" placeholder="Jelaskan ruang lingkup dan tujuan kerjasama.">{{ old('deskripsi', $agreement->deskripsi) }}</textarea>
        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="file" class="form-label fw-semibold">Dokumen PDF</label>
        @if($agreement->file_path)
            <div class="mb-2">
                <a href="{{ asset('storage/' . $agreement->file_path) }}" target="_blank" rel="noopener noreferrer" class="small">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Lihat dokumen saat ini
                </a>
            </div>
        @endif
        <input type="file" id="file" name="file" accept="application/pdf"
               class="form-control @error('file') is-invalid @enderror">
        <div class="form-text">Opsional, format PDF maksimal 20 MB.</div>
        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="tautan" class="form-label fw-semibold">Tautan Dokumen</label>
        <input type="url" id="tautan" name="tautan"
               class="form-control @error('tautan') is-invalid @enderror"
               value="{{ old('tautan', $agreement->tautan) }}" maxlength="2048"
               placeholder="https://...">
        <div class="form-text">Gunakan jika dokumen tersedia di situs atau penyimpanan eksternal.</div>
        @error('tautan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-4">
        <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" min="0"
               class="form-control @error('urutan') is-invalid @enderror"
               value="{{ old('urutan', $agreement->urutan ?? 0) }}">
        @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-8 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input type="checkbox" class="form-check-input" id="aktif" name="aktif" value="1"
                   {{ old('aktif', $agreement->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif" class="form-check-label fw-semibold">Publikasikan di halaman mitra</label>
        </div>
    </div>
</div>
