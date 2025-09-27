<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> E-Visa | Dashboard </title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" type="image/x-icon" href="{{ asset('frontendAssets') }}/img/passport-fill.svg">

    <!-- Fonts and icons -->
    <script src="{{ asset('backendAssets') }}/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            }
            , custom: {
                families: [
                    "Font Awesome 5 Solid"
                    , "Font Awesome 5 Regular"
                    , "Font Awesome 5 Brands"
                    , "simple-line-icons"
                , ]
                , urls: ["{{ asset('backendAssets') }}/css/fonts.min.css"]
            , }
            , active: function() {
                sessionStorage.fonts = true;
            }
        , });

    </script>

    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backendAssets') }}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('backendAssets') }}/css/plugins.min.css" />
    <link rel="stylesheet" href="{{ asset('backendAssets') }}/css/kaiadmin.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('backend.include.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('backend.include.header')

            @yield('content')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('backendAssets') }}/js/core/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('backendAssets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('backendAssets') }}/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backendAssets') }}/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ asset('backendAssets') }}/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('backendAssets') }}/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('backendAssets') }}/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('backendAssets') }}/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('backendAssets') }}/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('backendAssets') }}/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="{{ asset('backendAssets') }}/js/plugin/jsvectormap/world.js"></script>

    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script src="{{ asset('backendAssets') }}/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('backendAssets') }}/tinymce/plugins/code/plugin.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('backendAssets') }}/js/kaiadmin.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });

    </script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify({});
        });

    </script>

<script>
    $(document).ready(function () {
        flatpickr(".flat_date", {
            dateFormat: "Y-m-d",
            allowInput: true
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

<script>
    tinymce.init({ selector: '#default' });
    tinymce.init({ selector: '#dark', toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code', plugins: 'code' });
</script>

</body>
</html>
