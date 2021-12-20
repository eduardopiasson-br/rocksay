<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" <!-- CSS
        Files -->
    <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />
    {{-- Admin css --}}
    <link href="{{ asset('light-bootstrap/css/admin.css') }}" rel="stylesheet" />
    {{-- Crop Image --}}
    <link href="{{ asset('ijaboCropTool-master/ijaboCropTool.min.css') }}" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')
    <div class="wrapper @if (!auth()->check() ||
        request()->route()->getName() == '') wrapper-full-page @endif">

        @if (auth()->check() &&
    request()->route()->getName() != '')
            @include('admin.layouts.navbars.sidebar')
        @endif

        <div class="@if (auth()->check() &&
            request()->route()->getName() != '') main-panel @endif">
            @include('admin.layouts.navbars.navbar')
            @yield('content')
            @include('admin.layouts.footer.nav')
        </div>

    </div>



</body>
<!--   Core JS Files   -->
<script src="{{ asset('light-bootstrap/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
<!-- Plugin para interruptores, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
{{-- <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script> --}}
<!--  Chartist Plugin  -->
{{-- <script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script> --}}
<!--  Notifications Plugin    -->
{{-- <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script> --}}
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
{{-- JS Crop Image --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('ijaboCropTool-master/ijaboCropTool.min.js') }} "></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
<script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>
@stack('js')

</html>
