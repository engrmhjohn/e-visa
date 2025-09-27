<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="{{ asset('frontendAssets') }}/img/passport-fill.svg" rel="icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('frontendAssets') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontendAssets') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontendAssets') }}/vendor/aos/aos.css" rel="stylesheet">

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('frontendAssets') }}/css/main.css" rel="stylesheet">
    @stack('style')
    <style>
        .select2-container--open .select2-search__field {
            border: none;
            outline: none;
            box-shadow: none;
            height: 100%;
            padding: 8px;
            margin: 0;
            width: 100%;
        }

        .select2-container--default .select2-selection--single {
            height: 50px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 47px;
        }

    </style>
</head>

<body class="index-page scrolled">
    @include('frontend.include.header')
    <main class="main">
        @yield('content')
    </main>
    @include('frontend.include.footer')
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('frontendAssets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontendAssets') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontendAssets') }}/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="{{ asset('frontendAssets') }}/vendor/typed.js/typed.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontendAssets') }}/js/main.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%', 
                minimumResultsForSearch: 0, // always show search
                placeholder: "Select an option", 
                allowClear: true
            });

            // Auto focus search box when Select2 opens
            $(document).on('select2:open', function() {
                let searchField = document.querySelector('.select2-container--open .select2-search__field');
                if (searchField) {
                    searchField.focus();
                    searchField.select();
                }
            });

            // Initialize Dropify
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop or click to upload'
                    , 'replace': 'Drag and drop or click to replace'
                    , 'remove': 'Remove'
                    , 'error': 'Oops, something went wrong.'
                }
            });

            // Initialize Flatpickr
            flatpickr(".flat_date", {
                dateFormat: "Y-m-d"
            });
        });

    </script>

    <script>
        $('.delete_unique').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                title: 'Do you want to delete this?'
                , text: "Once deleted, you will not be able to recover this!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, delete it'
                , reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    </script>
    @stack('script')
</body>
</html>
