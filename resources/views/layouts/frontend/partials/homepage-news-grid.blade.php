{{-- Status filter pencarian jika ada --}}
@if(!empty($search))
  <div class="col-12 mb-3">
    <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-pill bg-light border">
      <span class="small text-muted">
        <i class="bi bi-search me-1" style="color: var(--uis-purple, #046B26);"></i> Hasil pencarian: <strong>"{{ $search }}"</strong> ({{ $latestNews->total() }} berita ditemukan)
      </span>
      <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-semibold" id="btnResetNewsSearch" style="font-size: 12px;">
        <i class="bi bi-x-circle me-1"></i> Reset
      </button>
    </div>
  </div>
@endif

{{-- Grid Daftar Berita (2 Kolom) --}}
<div class="row g-3">
  @if(isset($latestNews) && $latestNews->count() > 0)
    @foreach($latestNews as $news)
      <div class="col-sm-6">
        <a href="{{ route('homepage.news.detail', $news->slug ?? $news->id) }}" class="news-mini-item">
          <div class="news-mini-img-wrap">
            @php
              $miniThumb = !empty($news->thumbnail) 
                ? asset('storage/' . $news->thumbnail) 
                : (!empty($news->gallery[0]) ? asset('storage/' . $news->gallery[0]) : null);
            @endphp
            @if($miniThumb)
              <img src="{{ $miniThumb }}" alt="{{ $news->title }}" class="news-mini-img" loading="lazy">
            @else
              <div class="news-mini-fallback" style="background-color: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('frontend/img/logouis.png') }}" alt="UIS" style="max-height: 28px; opacity: 0.5;">
              </div>
            @endif
          </div>
          <div class="news-mini-content">
            <h6 class="news-mini-title">{{ $news->title }}</h6>
            <div class="news-mini-meta">
              {{ $news->created_at ? $news->created_at->format('d F Y // H:i') : '-' }}
            </div>
          </div>
        </a>
      </div>
    @endforeach
  @else
    <div class="col-12 text-muted py-5 text-center">
      <div class="mb-2">
        <i class="bi bi-search fs-1 text-muted opacity-50"></i>
      </div>
      <p class="mb-1 fw-semibold text-dark">Tidak ada berita yang ditemukan{{ !empty($search) ? ' untuk "' . $search . '"' : '' }}.</p>
      <p class="small text-muted mb-3">Silakan gunakan kata kunci lain atau periksa kembali ejaan pencarian Anda.</p>
      @if(!empty($search))
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btnResetNewsSearchFallback">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Tampilkan Semua Berita
        </button>
      @endif
    </div>
  @endif
</div>

{{-- Pagination Berita --}}
@if(isset($latestNews) && method_exists($latestNews, 'hasPages') && $latestNews->hasPages())
  <div class="d-flex justify-content-center mt-4 pt-2" id="homepageNewsPaginationWrap">
    {{ $latestNews->fragment('berita')->links('pagination::bootstrap-5') }}
  </div>
@endif
