@php
    $pageKey = $pageKey ?? null;
    $bc = $pageKey ? \App\Models\Breadcrumb::getForPage($pageKey) : null;
    $heroClass = $heroClass ?? 'page-hero-banner';

    // Fallbacks
    $badge = $bc?->badge_text ?? ($defaultBadge ?? null);
    $title = $bc?->judul ?? ($defaultTitle ?? 'Universitas Ibnu Sina (UIS)');
    $subtitle = $bc?->subjudul ?? ($defaultSubtitle ?? null);
    $item1 = $bc?->breadcrumb_item_1 ?: ($defaultItem1 ?? 'Beranda');
    $url1 = $bc?->breadcrumb_url_1 ?: ($defaultUrl1 ?? route('homepage'));
    $item2 = $bc?->breadcrumb_item_2 ?? ($parentTitle ?? null);
    $url2 = $bc?->breadcrumb_url_2 ?? ($parentUrl ?? null);
    $active = $bc?->breadcrumb_active ?? ($defaultActive ?? 'Halaman');
    $bgImage = $bc?->bg_image_url ?? null;
    $isActive = $bc ? $bc->is_active : true;
@endphp

@if($isActive)
<div class="{{ $heroClass }}" @if($bgImage) style="background: linear-gradient(135deg, rgba(4, 107, 38, 0.88) 0%, rgba(2, 56, 20, 0.94) 100%), url('{{ $bgImage }}') center/cover no-repeat !important; border-bottom: 3px solid var(--uis-orange, #fed802) !important;" @endif>
  <div class="container">
    <div class="page-hero-content" data-aos="fade-up" data-aos-duration="800">
      @if(!empty($badge))
        <div class="badge px-3 py-1 rounded-pill mb-2" style="background: rgba(4, 107, 38, 0.45); color: var(--uis-orange, #fed802); border: 1px solid rgba(254, 216, 2, 0.4); font-size: 11px;">
          <i class="bi bi-bookmark-star-fill me-1"></i> {{ $badge }}
        </div>
      @endif

      <h1 class="page-hero-title mb-1" style="color: #ffffff; font-weight: 800; font-size: 26px; line-height: 1.25; font-family: 'Plus Jakarta Sans', sans-serif;">
        {!! $title !!}
      </h1>

      @if(!empty($subtitle))
        <p class="text-white-50 mb-2" style="max-width: 720px; font-size: 13.5px; line-height: 1.5;">
          {{ $subtitle }}
        </p>
      @endif

      <div class="breadcrumb-custom">
        <a href="{{ $url1 }}"><i class="bi bi-house-door-fill me-1"></i>{{ $item1 }}</a>
        @if(!empty($item2))
          <span>/</span>
          @if(!empty($url2))
            <a href="{{ $url2 }}">{{ $item2 }}</a>
          @else
            <span>{{ $item2 }}</span>
          @endif
        @endif
        <span>/</span>
        <span class="active">{{ $active }}</span>
      </div>
    </div>
  </div>
</div>
@endif
