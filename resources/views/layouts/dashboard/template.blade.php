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

    <style>
        :root {
            --uis-purple: #046B26;
            --uis-purple-dark: #03521d;
            --uis-orange: #FED802;
            --uis-orange-dark: #e5c302;
        }
        /* Header — Solid Purple #046B26 */
        .header {
            background-color: #046B26 !important;
            border-bottom: 2.5px solid #FED802 !important;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.16) !important;
        }
        .header .logo span {
            color: #FED802 !important;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .header .toggle-sidebar-btn {
            color: #ffffff !important;
        }
        .header .toggle-sidebar-btn:hover {
            color: #FED802 !important;
        }
        .header .nav-profile {
            color: #ffffff !important;
        }
        .header .nav-profile span {
            color: #ffffff !important;
            font-weight: 700;
        }
        .header .nav-profile:hover span {
            color: #FED802 !important;
        }
        .header .nav-icon {
            color: #ffffff !important;
        }
        .header .nav-icon:hover {
            color: #FED802 !important;
        }
        .sidebar-nav .nav-link {
            background: #f8fcf9;
            color: #046B26;
        }
        .sidebar-nav .nav-link:not(.collapsed) {
            background: #eaf6ee;
            color: #046B26;
        }
        .sidebar-nav .nav-link:not(.collapsed) i {
            color: #046B26;
        }
        .sidebar-nav .nav-content a.active {
            color: #046B26;
            font-weight: 700;
        }
        .sidebar-nav .nav-content a.active i {
            background-color: #FED802;
        }
        .sidebar-nav .nav-link:hover {
            color: #FED802;
            background: #f8fcf9;
        }
        .sidebar-nav .nav-link:hover i {
            color: #FED802;
        }
        .btn-primary {
            background-color: #046B26 !important;
            border-color: #046B26 !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #03521d !important;
            border-color: #03521d !important;
        }
        .btn-outline-primary {
            color: #046B26 !important;
            border-color: #046B26 !important;
        }
        .btn-outline-primary:hover {
            background-color: #046B26 !important;
            color: #fff !important;
        }
        .btn-warning {
            background-color: #FED802 !important;
            border-color: #FED802 !important;
            color: #fff !important;
        }
        .btn-warning:hover {
            background-color: #e5c302 !important;
            border-color: #e5c302 !important;
            color: #fff !important;
        }
        .pagetitle h1 {
            color: #046B26;
        }
        .card-title {
            color: #046B26;
        }
        .back-to-top {
            background: #046B26;
        }
        .back-to-top:hover {
            background: #FED802;
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
    </script>

    <!-- TinyMCE CDN & Global Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof tinymce !== 'undefined') {
                const selector = 'textarea.tinymce-editor, textarea.tinymce, textarea#content, textarea#deskripsi, textarea#sambutan_dekan, textarea#answer, textarea#jawaban, textarea#sejarah, textarea#visi, textarea#misi, textarea#deskripsi_profil_1, textarea#deskripsi_profil_2';
                
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

    @stack('scripts')
    @stack('styles')

</body>

</html>
