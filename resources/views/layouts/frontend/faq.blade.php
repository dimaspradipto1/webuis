@extends('layouts.frontend.template')

@section('title', 'Tanya Jawab (FAQ) — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Temukan jawaban cepat atas pertanyaan seputar fakultas, program studi, PMB, fasilitas kampus, dan akreditasi UIS Batam.')
@section('meta_keywords', 'faq uis, tanya jawab universitas ibnu sina, pmb uis batam, pendaftaran mahasiswa baru, akreditasi uis batam')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'faq',
    'heroClass' => 'faq-hero'
])

<!-- ═══════════════════════════════════════════════
     FAQ SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <div class="accordion" id="faqAccordion">
          @if(isset($faqs) && $faqs->count() > 0)
            @foreach($faqs as $index => $faq)
              <div class="accordion-item shadow-sm">
                <h2 class="accordion-header" id="heading{{ $faq->id ?? $index }}">
                  <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id ?? $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                    <i class="bi bi-question-circle-fill me-2" style="color: var(--uis-purple);"></i>
                    {{ $faq->question ?? $faq->pertanyaan }}
                  </button>
                </h2>
                <div id="collapse{{ $faq->id ?? $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    {{ trim(html_entity_decode(strip_tags($faq->answer ?? $faq->jawaban ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="text-center py-4 text-muted">Belum ada data FAQ tersedia.</div>
          @endif
        </div>

        <div class="card border-0 shadow-sm p-4 text-center mt-5" style="border-radius: 20px; background: var(--obsidian-dark); color: white;">
          <h4 class="fw-bold mb-2">Masih Memiliki Pertanyaan Lain?</h4>
          <p class="text-white-50 small mb-3">Tim layanan informasi akademik kami siap membantu menjawab segala pertanyaan Anda.</p>
          <div class="d-flex justify-content-center gap-3">
            @if(!empty($cleanWa))
              <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="btn-primary-hero">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
              </a>
            @endif
            <a href="{{ route('homepage.kontak') }}" class="btn-outline-hero">
              <i class="bi bi-envelope"></i> Kontak Kami
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

@endsection
