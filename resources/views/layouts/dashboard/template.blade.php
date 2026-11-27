<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <title>Dashboard Portal — Universitas Ibnu Sina (UIS)</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('assets/img/logouis.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    {{--  datatables CSS  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.css">

    @stack('styles')

    <style id="dynamic-admin-theme">
        :root {
            --uis-purple: {{ $themeSetting->admin_primary_color ?? '#046B26' }};
            --uis-purple-dark: {{ $themeSetting->admin_primary_color ?? '#03521d' }};
            --uis-orange: {{ $themeSetting->admin_accent_color ?? '#FED802' }};
            --uis-orange-dark: {{ $themeSetting->admin_accent_color ?? '#e5c302' }};
            --admin-hdr-h: {{ $themeSetting->admin_header_height ?? 78 }}px;
        }
        /* Header — Dynamic Admin Theme */
        .header {
            height: var(--admin-hdr-h, 78px) !important;
            background-color: {{ $themeSetting->admin_header_bg_color ?? '#046B26' }} !important;
            border-bottom: 3px solid {{ $themeSetting->admin_header_border_color ?? '#FED802' }} !important;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.16) !important;
        }
        #main {
            margin-top: calc(var(--admin-hdr-h, 78px) + 3px) !important;
            padding: 24px 30px !important;
        }
        .sidebar {
            top: calc(var(--admin-hdr-h, 78px) + 3px) !important;
            background-color: {{ $themeSetting->admin_sidebar_bg_color ?? '#ffffff' }} !important;
        }
        .pagetitle {
            margin-bottom: 18px !important;
            padding-top: 6px !important;
        }
        .pagetitle h1 {
            color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            line-height: 1.35 !important;
            margin-bottom: 4px !important;
        }
        .pagetitle .breadcrumb {
            margin-bottom: 0 !important;
            font-size: 13px !important;
        }
        .header .logo img {
            max-height: 46px !important;
            height: 46px !important;
        }
        .header .logo span {
            color: {{ $themeSetting->admin_header_brand_color ?? '#FED802' }} !important;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .header .toggle-sidebar-btn {
            color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }} !important;
        }
        .header .toggle-sidebar-btn:hover {
            color: {{ $themeSetting->admin_accent_color ?? '#FED802' }} !important;
        }
        .header .nav-profile {
            color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }} !important;
        }
        .header .nav-profile span {
            color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }} !important;
            font-weight: 700;
        }
        .header .nav-profile:hover span {
            color: {{ $themeSetting->admin_accent_color ?? '#FED802' }} !important;
        }
        .header .nav-icon {
            color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }} !important;
        }
        .header .nav-icon:hover {
            color: {{ $themeSetting->admin_accent_color ?? '#FED802' }} !important;
        }
        .sidebar {
            background-color: {{ $themeSetting->admin_sidebar_bg_color ?? '#ffffff' }} !important;
        }
        .sidebar-nav .nav-link.collapsed {
            background: {{ $themeSetting->admin_sidebar_bg_color ?? '#ffffff' }};
            color: {{ $themeSetting->admin_sidebar_text_color ?? '#046B26' }};
        }
        .sidebar-nav .nav-link.collapsed i {
            color: {{ $themeSetting->admin_sidebar_text_color ?? '#046B26' }};
        }
        .sidebar-nav .nav-link {
            background: {{ $themeSetting->admin_sidebar_active_bg_color ?? '#eaf6ee' }};
            color: {{ $themeSetting->admin_sidebar_active_text_color ?? '#046B26' }};
        }
        .sidebar-nav .nav-link:not(.collapsed) {
            background: {{ $themeSetting->admin_sidebar_active_bg_color ?? '#eaf6ee' }};
            color: {{ $themeSetting->admin_sidebar_active_text_color ?? '#046B26' }};
            border-left: 4px solid {{ $themeSetting->admin_accent_color ?? '#FED802' }};
        }
        .sidebar-nav .nav-link:not(.collapsed) i {
            color: {{ $themeSetting->admin_sidebar_active_text_color ?? '#046B26' }};
        }
        .sidebar-nav .nav-content a {
            color: {{ $themeSetting->admin_sidebar_text_color ?? '#046B26' }};
        }
        .sidebar-nav .nav-content a.active {
            color: {{ $themeSetting->admin_sidebar_active_text_color ?? '#046B26' }};
            font-weight: 700;
        }
        .sidebar-nav .nav-content a.active i {
            background-color: {{ $themeSetting->admin_accent_color ?? '#FED802' }};
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.collapsed:hover {
            color: {{ $themeSetting->admin_sidebar_hover_text_color ?? '#FED802' }};
            background: {{ $themeSetting->admin_sidebar_hover_bg_color ?? '#f8fcf9' }};
        }
        .sidebar-nav .nav-link:hover i,
        .sidebar-nav .nav-link.collapsed:hover i {
            color: {{ $themeSetting->admin_sidebar_hover_text_color ?? '#FED802' }};
        }
        .btn-primary {
            background-color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
            border-color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
            color: #ffffff !important;
        }
        .btn-primary *, .btn-primary i {
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: {{ $themeSetting->admin_primary_color ?? '#03521d' }} !important;
            border-color: {{ $themeSetting->admin_primary_color ?? '#03521d' }} !important;
            color: #ffffff !important;
            filter: brightness(0.92);
        }
        .btn-success {
            background-color: #046B26 !important;
            border-color: #046B26 !important;
            color: #ffffff !important;
        }
        .btn-success *, .btn-success i {
            color: #ffffff !important;
        }
        .btn-success:hover, .btn-success:focus {
            background-color: #03521d !important;
            border-color: #03521d !important;
            color: #ffffff !important;
        }
        .btn-outline-primary {
            color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
            border-color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
        }
        .btn-outline-primary:hover {
            background-color: {{ $themeSetting->admin_primary_color ?? '#046B26' }} !important;
            color: #fff !important;
        }
        .btn-warning,
        .btn-warning.text-white,
        a.btn-warning,
        button.btn-warning {
            background-color: {{ $themeSetting->admin_accent_color ?? '#FED802' }} !important;
            border-color: {{ $themeSetting->admin_accent_color ?? '#FED802' }} !important;
            color: #111827 !important;
            font-weight: 700 !important;
        }
        .btn-warning *,
        .btn-warning i,
        .btn-warning span {
            color: #111827 !important;
        }
        .btn-warning:hover,
        .btn-warning:focus,
        .btn-warning:active {
            background-color: {{ $themeSetting->admin_accent_color ?? '#e5c302' }} !important;
            border-color: {{ $themeSetting->admin_accent_color ?? '#e5c302' }} !important;
            color: #111827 !important;
            filter: brightness(0.94);
        }
        .btn-warning:hover *,
        .btn-warning:hover i {
            color: #111827 !important;
        }
        .card-title {
            color: {{ $themeSetting->admin_primary_color ?? '#046B26' }};
        }
        .back-to-top {
            background: {{ $themeSetting->admin_primary_color ?? '#046B26' }};
        }
        .back-to-top:hover {
            background: {{ $themeSetting->admin_accent_color ?? '#FED802' }};
        }
        /* Global Nav Pills & Active Elements UIS Theme (NO BLUE) */
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background-color: #046B26 !important;
            color: #ffffff !important;
            border-color: #046B26 !important;
        }
        .nav-pills .nav-link.active *,
        .nav-pills .nav-link.active i {
            color: #ffffff !important;
        }
        .nav-tabs .nav-link.active {
            color: #046B26 !important;
            border-bottom: 2px solid #046B26 !important;
            background-color: #ffffff !important;
        }
        .page-item.active .page-link {
            background-color: #046B26 !important;
            border-color: #046B26 !important;
            color: #ffffff !important;
        }
        .form-check-input:checked {
            background-color: #046B26 !important;
            border-color: #046B26 !important;
        }
        .badge.bg-primary {
            background-color: #046B26 !important;
            color: #ffffff !important;
        }
        .badge.bg-success {
            background-color: #046B26 !important;
            color: #ffffff !important;
        }
        .badge.bg-warning {
            background-color: #FED802 !important;
            color: #111827 !important;
        }
        /* Ensure readable text in all green card headers & green banners */
        .card[style*="#046B26"], .card[style*="#046b26"],
        .card[style*="linear-gradient"],
        .card-header.bg-success,
        .modal-header[style*="#046B26"], .modal-header[style*="#046b26"],
        .modal-header[style*="#2e6b34"], .modal-header[style*="#032e12"],
        .modal-header.bg-success {
            color: #ffffff !important;
        }
        .card[style*="#046B26"] h1, .card[style*="#046B26"] h2, .card[style*="#046B26"] h3,
        .card[style*="#046B26"] h4, .card[style*="#046B26"] h5, .card[style*="#046B26"] h6,
        .card[style*="#046B26"] .card-title,
        .card[style*="#046b26"] h1, .card[style*="#046b26"] h2, .card[style*="#046b26"] h3,
        .card[style*="#046b26"] h4, .card[style*="#046b26"] h5, .card[style*="#046b26"] h6,
        .card[style*="#046b26"] .card-title,
        .card[style*="linear-gradient"] h1, .card[style*="linear-gradient"] h2,
        .card[style*="linear-gradient"] h3, .card[style*="linear-gradient"] h4,
        .card[style*="linear-gradient"] h5, .card[style*="linear-gradient"] h6,
        .card[style*="linear-gradient"] .card-title,
        .card-header.bg-success h1, .card-header.bg-success h2, .card-header.bg-success h3,
        .card-header.bg-success h4, .card-header.bg-success h5, .card-header.bg-success h6,
        .modal-header[style*="#046B26"] .modal-title,
        .modal-header[style*="#046b26"] .modal-title,
        .modal-header[style*="#2e6b34"] .modal-title,
        .modal-header[style*="#032e12"] .modal-title,
        .modal-header.bg-success .modal-title {
            color: #ffffff !important;
        }

        /* ═══════════════════════════════════════════════════════════════
           RESPONSIVE RATIO OPTIMIZATION FOR 14-INCH LAPTOPS (1200px - 1440px)
           AND 768p VIEWPORTS (1366x768 / 1280x720 / 125%-150% SCALING)
        ═══════════════════════════════════════════════════════════════ */
        @media (min-width: 1200px) and (max-width: 1440px) {
            .sidebar {
                width: 250px !important;
                padding: 16px 10px !important;
            }
            #main,
            #footer {
                margin-left: 250px !important;
                padding: 18px 20px !important;
            }
            .toggle-sidebar #main,
            .toggle-sidebar #footer {
                margin-left: 0 !important;
            }
            .toggle-sidebar .sidebar {
                left: -250px !important;
            }
            .header .logo img {
                max-height: 28px !important;
            }
            .header .logo span {
                font-size: 17px !important;
            }
            .sidebar-nav .nav-link {
                font-size: 13px !important;
                padding: 8px 12px !important;
            }
            .sidebar-nav .nav-link i {
                font-size: 15px !important;
                margin-right: 8px !important;
            }
            .sidebar-nav .nav-content a {
                font-size: 12.5px !important;
                padding: 6px 0 6px 30px !important;
            }
            .sidebar-nav .nav-heading {
                font-size: 10px !important;
                padding: 8px 12px 4px !important;
            }
            .pagetitle h1 {
                font-size: 20px !important;
            }
            .card-header {
                padding: 10px 16px !important;
            }
            .card-body {
                padding: 14px 16px !important;
            }
            .table {
                font-size: 13px !important;
            }
            .table th,
            .table td {
                padding: 7px 10px !important;
            }
            .form-control,
            .form-select {
                font-size: 13px !important;
                padding: 6px 12px !important;
            }
            .btn {
                font-size: 13px !important;
            }
        }

        @media (max-height: 800px) and (min-width: 992px) {
            #main {
                margin-top: calc(var(--admin-hdr-h, 78px) + 3px) !important;
                padding-top: 18px !important;
                padding-bottom: 20px !important;
            }
            .pagetitle {
                margin-bottom: 12px !important;
                padding-top: 4px !important;
            }
            .card {
                margin-bottom: 16px !important;
            }
        }
    </style>
</head>

<body>
    @include('layouts.dashboard.header')
    @include('layouts.dashboard.sidebar')


    <main id="main" class="main">
        @include('sweetalert::alert')

        @yield('content')

    </main>

    @include('layouts.dashboard.footer')



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- jQuery & DataTables JS (Required for all Admin DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Global SweetAlert2 Handlers --}}
    <script>
        // Global Logout Confirmation with SweetAlert2
        window.confirmLogout = function (e, url) {
            if (e) e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#046B26',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                    cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url || "{{ route('logout') }}";
                }
            });
            return false;
        };

        // Intercept DataTables & Form Deletions with SweetAlert2
        $(document).on('submit', 'form', function (e) {
            const form = this;
            const isDelete = $(form).find('input[name="_method"][value="DELETE"]').length > 0;
            const onsubmitAttr = form.getAttribute('onsubmit') || '';
            const hasConfirm = onsubmitAttr.includes('confirm');
            
            if ((isDelete || hasConfirm) && !form.dataset.swalConfirmed) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let title = 'Apakah Anda yakin?';
                let text = 'Data yang dihapus tidak dapat dikembalikan!';

                // Extract custom message if present in onsubmit="return confirm('...')"
                const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match && match[1]) {
                    title = match[1];
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                        cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.swalConfirmed = 'true';
                        form.removeAttribute('onsubmit');
                        form.submit();
                    }
                });

                return false;
            }
        });

        // ═══════════════════════════════════════════════════════════════
        // GLOBAL SWEETALERT2 FILE SIZE & FILE LIMIT VALIDATOR
        // ═══════════════════════════════════════════════════════════════
        $(document).on('change', 'input[type="file"]', function () {
            const input = this;
            const files = input.files;
            if (!files || files.length === 0) return;

            // Tentukan batas maksimal dalam MB (default: 5 MB untuk gambar, 20 MB untuk dokumen)
            let maxMB = parseFloat(input.getAttribute('data-max-size'));
            if (!maxMB || isNaN(maxMB)) {
                const accept = (input.getAttribute('accept') || '').toLowerCase();
                if (accept.includes('image') || accept.includes('png') || accept.includes('jpg') || accept.includes('webp')) {
                    maxMB = 5;
                } else {
                    maxMB = 20;
                }
            }

            const maxBytes = maxMB * 1024 * 1024;
            let oversizedFiles = [];

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxBytes) {
                    const sizeMB = (files[i].size / (1024 * 1024)).toFixed(2);
                    oversizedFiles.push(`<b>${files[i].name}</b> (${sizeMB} MB)`);
                }
            }

            if (oversizedFiles.length > 0) {
                const fileListText = oversizedFiles.join('<br>');
                input.value = ''; // Reset input seketika agar file tidak terkirim

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran Berkas Terlalu Besar!',
                        html: `
                            <div class="text-start mt-2">
                                <p class="mb-2 text-dark">Berkas berikut melebihi batas maksimal <b>${maxMB} MB</b> yang ditentukan:</p>
                                <div class="p-2.5 mb-3 bg-light rounded-3 border text-danger small font-monospace">${fileListText}</div>
                                <div class="alert alert-warning py-2 px-3 small mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-exclamation-triangle-fill fs-5 text-warning flex-shrink-0"></i>
                                    <span>Mohon pilih berkas dengan ukuran lebih kecil atau kompres terlebih dahulu agar tidak ditolak oleh server hosting (Error 403 / Payload Too Large).</span>
                                </div>
                            </div>
                        `,
                        confirmButtonColor: '#046B26',
                        confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Saya Mengerti',
                        customClass: {
                            popup: 'rounded-4 shadow-lg border-0',
                            confirmButton: 'px-4 py-2 rounded-3 fw-semibold'
                        }
                    });
                } else {
                    alert(`Ukuran berkas melebihi batas maksimal ${maxMB} MB. Silakan pilih berkas yang lebih kecil.`);
                }
            }
        });

        // Intercept form submit jika terdapat file yang melebihi batas
        $(document).on('submit', 'form', function (e) {
            const form = this;
            let hasOversized = false;
            let oversizedMsg = [];

            $(form).find('input[type="file"]').each(function () {
                const input = this;
                const files = input.files;
                if (!files || files.length === 0) return;

                let maxMB = parseFloat(input.getAttribute('data-max-size'));
                if (!maxMB || isNaN(maxMB)) {
                    const accept = (input.getAttribute('accept') || '').toLowerCase();
                    maxMB = (accept.includes('image') || accept.includes('png') || accept.includes('jpg') || accept.includes('webp')) ? 5 : 20;
                }
                const maxBytes = maxMB * 1024 * 1024;

                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > maxBytes) {
                        hasOversized = true;
                        oversizedMsg.push(`<b>${files[i].name}</b> (${(files[i].size / (1024 * 1024)).toFixed(2)} MB, batas: ${maxMB} MB)`);
                    }
                }
            });

            if (hasOversized) {
                e.preventDefault();
                e.stopImmediatePropagation();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Dapat Menyimpan Data!',
                        html: `
                            <div class="text-start mt-2">
                                <p class="mb-2 text-dark">Terdapat berkas yang melebihi batas maksimal server:</p>
                                <div class="p-2.5 mb-3 bg-light rounded-3 border text-danger small font-monospace">${oversizedMsg.join('<br>')}</div>
                                <p class="text-muted small mb-0">Silakan ganti berkas di atas dengan ukuran yang sesuai sebelum melanjutkan.</p>
                            </div>
                        `,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Tutup',
                        customClass: {
                            popup: 'rounded-4 shadow-lg border-0',
                            confirmButton: 'px-4 py-2 rounded-3 fw-semibold'
                        }
                    });
                } else {
                    alert('Terdapat berkas yang melebihi batas ukuran maksimal server.');
                }
                return false;
            }
        });
    </script>

    <!-- TinyMCE CDN & Global Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof tinymce !== 'undefined') {
                const selector = 'textarea.tinymce-editor, textarea.tinymce, textarea#content, textarea#sambutan_dekan, textarea#sejarah, textarea#deskripsi_profil_1, textarea#deskripsi_profil_2';
                
                document.querySelectorAll(selector).forEach(function (el) {
                    if (!tinymce.get(el.id || el)) {
                        tinymce.init({
                            target: el,
                            height: 380,
                            menubar: false,
                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image togglecaption | removeformat | code fullscreen',
                            content_style: 'body { font-family: Plus Jakarta Sans, Arial, sans-serif; font-size: 14px; line-height: 1.6; } img { max-width: 100%; height: auto; border-radius: 6px; } figure.image { display: table; margin: 1rem auto; text-align: center; max-width: 100%; } figure.image img { display: block; margin: 0 auto; } figure.image figcaption { display: table-caption; caption-side: bottom; padding: 6px 10px 2px; font-size: 12.5px; color: #64748b; font-style: italic; text-align: center; background: #f8fafc; border-radius: 0 0 6px 6px; }',
                            image_title: true,
                            image_caption: true,
                            automatic_uploads: true,
                            paste_data_images: true,
                            file_picker_types: 'image',
                            setup: function (editor) {
                                editor.ui.registry.addButton('togglecaption', {
                                    text: 'Judul Gambar',
                                    icon: 'image',
                                    tooltip: 'Tambah / Edit Judul di Bawah Gambar (Caption)',
                                    onAction: function () {
                                        const node = editor.selection.getNode();
                                        const figure = node.closest ? node.closest('figure.image') : null;
                                        if (figure) {
                                            let figcap = figure.querySelector('figcaption');
                                            if (!figcap) {
                                                figcap = editor.dom.create('figcaption', {}, 'Tulis keterangan/judul gambar di sini...');
                                                figure.appendChild(figcap);
                                            }
                                            editor.selection.select(figcap, true);
                                            editor.selection.collapse(false);
                                        } else if (node.nodeName === 'IMG') {
                                            const imgHtml = node.outerHTML;
                                            const figureHtml = '<figure class="image">' + imgHtml + '<figcaption>Tulis keterangan/judul gambar di sini...</figcaption></figure>';
                                            editor.dom.replace(editor.dom.createFragment(figureHtml), node);
                                        } else {
                                            editor.execCommand('mceImage');
                                        }
                                    }
                                });

                                editor.ui.registry.addContextToolbar('imagecaptionbar', {
                                    predicate: function (node) {
                                        return node.nodeName === 'IMG' || (node.nodeName === 'FIGURE' && node.classList.contains('image'));
                                    },
                                    items: 'alignleft aligncenter alignright | togglecaption image',
                                    position: 'node',
                                    scope: 'node'
                                });
                            },
                            images_upload_handler: function (blobInfo, progress) {
                                return new Promise((resolve, reject) => {
                                    if (blobInfo.blob().size > 20 * 1024 * 1024) {
                                        reject('Ukuran file gambar maksimal 20 MB.');
                                        return;
                                    }

                                    const xhr = new XMLHttpRequest();
                                    xhr.withCredentials = false;
                                    xhr.open('POST', '{{ route("news.upload-image") }}');
                                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                                    xhr.upload.onprogress = (e) => {
                                        progress(e.loaded / e.total * 100);
                                    };

                                    xhr.onload = () => {
                                        if (xhr.status === 403 || xhr.status === 419) {
                                            reject({ message: 'Sesi berakhir atau CSRF token invalid.', remove: true });
                                            return;
                                        }
                                        if (xhr.status < 200 || xhr.status >= 300) {
                                            reject('Gagal upload gambar. HTTP Error: ' + xhr.status);
                                            return;
                                        }
                                        try {
                                            const json = JSON.parse(xhr.responseText);
                                            if (!json || typeof json.location !== 'string') {
                                                reject('Respon server tidak valid.');
                                                return;
                                            }
                                            resolve(json.location);
                                        } catch (e) {
                                            reject('Respon server error: ' + e.message);
                                        }
                                    };

                                    xhr.onerror = () => {
                                        reject('Gagal koneksi ke server saat mengunggah gambar.');
                                    };

                                    const formData = new FormData();
                                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                                    xhr.send(formData);
                                });
                            },
                            file_picker_callback: function (cb, value, meta) {
                                const input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept', 'image/*');

                                input.addEventListener('change', (e) => {
                                    const file = e.target.files[0];
                                    if (!file) return;

                                    if (file.size > 20 * 1024 * 1024) {
                                        if (typeof Swal !== 'undefined') {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Ukuran Gambar Terlalu Besar',
                                                text: 'Ukuran file gambar "' + file.name + '" melebihi batas maksimal 20 MB.',
                                                confirmButtonColor: '#046B26'
                                            });
                                        } else {
                                            alert('Ukuran file gambar maksimal 20 MB.');
                                        }
                                        return;
                                    }

                                    const reader = new FileReader();
                                    reader.addEventListener('load', () => {
                                        const id = 'blobid' + (new Date()).getTime();
                                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                        const base64 = reader.result.split(',')[1];
                                        const blobInfo = blobCache.create(id, file, base64);
                                        blobCache.add(blobInfo);

                                        cb(blobInfo.blobUri(), { title: file.name, alt: file.name });
                                    });
                                    reader.readAsDataURL(file);
                                });

                                input.click();
                            }
                        });
                    }
                });
            }

            // Broadcast realtime ke tab frontend ketika admin selesai menyimpan perubahan
            function broadcastRealtimeUpdate() {
                try {
                    const nowTs = Date.now().toString();
                    localStorage.setItem('uis_realtime_updated_at', nowTs);
                    if (typeof BroadcastChannel !== 'undefined') {
                        const bc = new BroadcastChannel('uis_realtime_channel');
                        bc.postMessage({ type: 'content_updated', timestamp: nowTs });
                        bc.close();
                    }
                } catch (e) {}
            }

            @if (session('success') || session('status') || session('sweetalert.alerted'))
                broadcastRealtimeUpdate();
            @endif

            try {
                if (sessionStorage.getItem('uis_admin_form_submitted') === '1') {
                    sessionStorage.removeItem('uis_admin_form_submitted');
                    broadcastRealtimeUpdate();
                }
            } catch (e) {}
        });

        // Trigger TinyMCE save & tandai form submit agar frontend di-trigger realtime setelah redirect
        $(document).on('submit', 'form', function () {
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
            try {
                sessionStorage.setItem('uis_admin_form_submitted', '1');
            } catch (e) {}
        });

        // Validasi client-side global: Maksimal 20 MB untuk upload file gambar di semua form
        $(document).on('change', 'input[type="file"]', function () {
            const files = this.files;
            if (!files || files.length === 0) return;

            const acceptAttr = (this.getAttribute('accept') || '').toLowerCase();
            const isImageInput = acceptAttr.includes('image') || acceptAttr.includes('png') || acceptAttr.includes('jpg') || acceptAttr.includes('jpeg') || acceptAttr.includes('webp') || acceptAttr.includes('svg');
            const maxBytes = 20 * 1024 * 1024; // 20 MB

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const isImageFile = (file.type && file.type.startsWith('image/')) || /\.(jpe?g|png|webp|svg|gif)$/i.test(file.name);

                if ((isImageInput || isImageFile) && file.size > maxBytes) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran File Terlalu Besar',
                            html: `File <strong>${file.name}</strong> berukuran <strong>${fileSizeMB} MB</strong>.<br>Maksimal ukuran file gambar yang diperbolehkan adalah <strong>20 MB</strong>.`,
                            confirmButtonColor: '#046B26',
                            customClass: {
                                popup: 'rounded-4 shadow-lg border-0',
                                confirmButton: 'px-4 py-2 rounded-3 fw-semibold'
                            }
                        });
                    } else {
                        alert(`File "${file.name}" berukuran ${fileSizeMB} MB. Maksimal ukuran gambar adalah 20 MB.`);
                    }

                    // Reset input file
                    $(this).val('');

                    // Reset preview jika ada di halaman
                    const $form = $(this).closest('form');
                    $form.find('#previewWrap').addClass('d-none');
                    $form.find('#previewImg').attr('src', '');
                    $form.find('#previewDim').text('');
                    $form.find('#logoPreviewWrap').addClass('d-none');
                    $form.find('#currentLogoPreview').addClass('d-none');

                    break;
                }
            }
        });
    </script>

    <script>
        // Live sync Admin Theme without reload
        (function () {
            window.applyLiveAdminTheme = function (t) {
                var styleEl = document.getElementById('dynamic-admin-theme');
                if (!styleEl) {
                    styleEl = document.createElement('style');
                    styleEl.id = 'dynamic-admin-theme';
                    document.head.appendChild(styleEl);
                }
                var hH = t.admin_header_height || 78;
                styleEl.innerHTML = `
                    :root {
                        --uis-purple: ${t.admin_primary_color || '#046B26'};
                        --uis-purple-dark: ${t.admin_primary_color || '#03521d'};
                        --uis-orange: ${t.admin_accent_color || '#FED802'};
                        --uis-orange-dark: ${t.admin_accent_color || '#e5c302'};
                        --admin-hdr-h: ${hH}px;
                    }
                    .header {
                        height: ${hH}px !important;
                        background-color: ${t.admin_header_bg_color || '#046B26'} !important;
                        border-bottom: 3px solid ${t.admin_header_border_color || '#FED802'} !important;
                        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.16) !important;
                    }
                    #main {
                        margin-top: calc(${hH}px + 3px) !important;
                        padding-top: 24px !important;
                    }
                    .sidebar {
                        top: calc(${hH}px + 3px) !important;
                        background-color: ${t.admin_sidebar_bg_color || '#ffffff'} !important;
                    }
                    .pagetitle {
                        margin-bottom: 18px !important;
                        padding-top: 6px !important;
                    }
                    .pagetitle h1 {
                        color: ${t.admin_primary_color || '#046B26'} !important;
                        font-size: 24px !important;
                        font-weight: 700 !important;
                        line-height: 1.35 !important;
                    }
                    .header .logo span {
                        color: ${t.admin_header_brand_color || '#FED802'} !important;
                        font-weight: 800;
                        letter-spacing: 0.5px;
                    }
                    .header .toggle-sidebar-btn { color: ${t.admin_header_text_color || '#ffffff'} !important; }
                    .header .toggle-sidebar-btn:hover { color: ${t.admin_accent_color || '#FED802'} !important; }
                    .header .nav-profile, .header .nav-profile span, .header .nav-icon {
                        color: ${t.admin_header_text_color || '#ffffff'} !important;
                    }
                    .header .nav-profile:hover span, .header .nav-icon:hover {
                        color: ${t.admin_accent_color || '#FED802'} !important;
                    }
                    .sidebar-nav .nav-link.collapsed {
                        background: ${t.admin_sidebar_bg_color || '#ffffff'};
                        color: ${t.admin_sidebar_text_color || '#046B26'};
                    }
                    .sidebar-nav .nav-link.collapsed i { color: ${t.admin_sidebar_text_color || '#046B26'}; }
                    .sidebar-nav .nav-link {
                        background: ${t.admin_sidebar_active_bg_color || '#eaf6ee'};
                        color: ${t.admin_sidebar_active_text_color || '#046B26'};
                    }
                    .sidebar-nav .nav-link:not(.collapsed) {
                        background: ${t.admin_sidebar_active_bg_color || '#eaf6ee'};
                        color: ${t.admin_sidebar_active_text_color || '#046B26'};
                        border-left: 4px solid ${t.admin_accent_color || '#FED802'};
                    }
                    .sidebar-nav .nav-link:not(.collapsed) i { color: ${t.admin_sidebar_active_text_color || '#046B26'}; }
                    .sidebar-nav .nav-content a { color: ${t.admin_sidebar_text_color || '#046B26'}; }
                    .sidebar-nav .nav-content a.active {
                        color: ${t.admin_sidebar_active_text_color || '#046B26'};
                        font-weight: 700;
                    }
                    .sidebar-nav .nav-content a.active i { background-color: ${t.admin_accent_color || '#FED802'}; }
                    .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.collapsed:hover {
                        color: ${t.admin_sidebar_hover_text_color || '#FED802'};
                        background: ${t.admin_sidebar_hover_bg_color || '#f8fcf9'};
                    }
                    .sidebar-nav .nav-link:hover i, .sidebar-nav .nav-link.collapsed:hover i {
                        color: ${t.admin_sidebar_hover_text_color || '#FED802'};
                    }
                    .btn-primary {
                        background-color: ${t.admin_primary_color || '#046B26'} !important;
                        border-color: ${t.admin_primary_color || '#046B26'} !important;
                        color: #ffffff !important;
                    }
                    .btn-primary *, .btn-primary i { color: #ffffff !important; }
                    .btn-success {
                        background-color: #046B26 !important;
                        border-color: #046B26 !important;
                        color: #ffffff !important;
                    }
                    .btn-success *, .btn-success i { color: #ffffff !important; }
                    .btn-outline-primary {
                        color: ${t.admin_primary_color || '#046B26'} !important;
                        border-color: ${t.admin_primary_color || '#046B26'} !important;
                    }
                    .btn-warning, .btn-warning.text-white, a.btn-warning, button.btn-warning {
                        background-color: ${t.admin_accent_color || '#FED802'} !important;
                        border-color: ${t.admin_accent_color || '#FED802'} !important;
                        color: #111827 !important;
                        font-weight: 700 !important;
                    }
                    .btn-warning *, .btn-warning i, .btn-warning span { color: #111827 !important; }
                    .badge.bg-warning { background-color: #FED802 !important; color: #111827 !important; }
                    .badge.bg-primary, .badge.bg-success { background-color: #046B26 !important; color: #ffffff !important; }
                    .pagetitle h1, .card-title { color: ${t.admin_primary_color || '#046B26'}; }
                    .back-to-top { background: ${t.admin_primary_color || '#046B26'}; }
                    .back-to-top:hover { background: ${t.admin_accent_color || '#FED802'}; }
                `;
            };

            // Broadcast current saved state to Frontend tabs on every Admin load
            var savedTheme = @json(isset($themeSetting) ? array_merge($themeSetting->only(array_keys(\App\Models\ThemeSetting::defaultAttributes())), ['layout' => $themeSetting->getLayoutSections()]) : null);
            try {
                if ('BroadcastChannel' in window) {
                    var bc = new BroadcastChannel('webuis_live_sync');
                    bc.postMessage({ type: 'content_update', theme: savedTheme, ts: Date.now() });
                }
                if (savedTheme) {
                    localStorage.setItem('webuis_live_theme', JSON.stringify({ theme: savedTheme, ts: Date.now() }));
                }
                localStorage.setItem('webuis_live_content_ping', String(Date.now()));
            } catch (e) {}
        })();
    </script>

    @stack('scripts')
    @stack('styles')

</body>

</html>
