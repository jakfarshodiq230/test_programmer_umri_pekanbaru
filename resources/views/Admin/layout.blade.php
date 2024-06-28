<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
    <meta name="author" content="Bootlab">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MY TAHFIDZ</title>
    <style>
        body {
            opacity: 0;
        }
    </style>
    <link href=" {{ asset('assets/admin/css/modern.css') }}" type="text/css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="{{ asset('assets/admin/js/settings.js') }}"></script>

</head>

<body>
    @include('sweetalert::alert')
    <div class="splash active">
        <div class="splash-icon"></div>
    </div>

    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <a class='sidebar-brand' href='{{ url('/') }}'>
                MY TAHFIDZ
            </a>
            <div class="sidebar-content">
                <div class="sidebar-user">
                    <img src="{{ asset('assets/admin/img/avatars/avatar.jpg') }}" class="img-fluid rounded-circle mb-2"
                        alt="Linda Miller" />
                    <div class="fw-bold">ADMIN/SUPERADMIN</div>
                    <small>ADMIN/SUPERADMIN</small>
                </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main
                    </li>
                    <li class="sidebar-item {{ $menu == 'main' ? 'active' : null }}">

                        <a data-bs-target="#main" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-tachometer"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                        <ul id="main" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                            <li class="sidebar-item {{ $submenu == 'home' ? 'active' : null }}"><a class='sidebar-link'
                                    href='{{ url('home') }}'>Default</a>
                            </li>
                            <li class="sidebar-item {{ $submenu == 'statistik' ? 'active' : null }}"><a
                                    class='sidebar-link' href='{{ url('home/statistik') }}'>Statistik</a>
                            </li>
                            <li class="sidebar-item {{ $submenu == 'log_akses' ? 'active' : null }}"><a
                                    class='sidebar-link' href='{{ url('log_akses') }}'>Akses Pelanggan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        Master
                    </li>
                    <li class="sidebar-item {{ $menu == 'master' ? 'active' : null }}">
                        <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-database"></i> <span
                                class="align-middle">Master</span>
                        </a>
                        <ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">

                            <li class="sidebar-item {{ $submenu == 'siswa' ? 'active' : null }}"><a
                                    class='sidebar-link' href='{{ url('siswa') }}'>Siswa</a>
                            </li>
                            <li class="sidebar-item {{ $submenu == 'guru' ? 'active' : null }}"><a class='sidebar-link'
                                    href='{{ url('guru') }}'>Guru</a>
                            </li>
                            <li class="sidebar-item {{ $submenu == 'tahun_ajaran' ? 'active' : null }}"><a
                                    class='sidebar-link' href='{{ url('tahun_ajaran') }}'>Tahun Ajaran</a>
                            <li class="sidebar-item {{ $submenu == 'kelas' ? 'active' : null }}"><a
                                    class='sidebar-link' href='{{ url('kelas') }}'>Kelas</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-header">
                        Transaksi
                    </li>
                    <li class="sidebar-item {{ $submenu == 'transaksi' ? 'active' : null }}">
                        <a class='sidebar-link' href='{{ url('transaksi') }}'>
                            <i class="align-middle me-2 fas fa-fw fa-address-card"></i> <span
                                class="align-middle">Transaksi</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Logout
                    </li>
                    <li class="sidebar-item">
                        <div class="d-flex justify-content-center"><a class='btn btn-outline-primary'
                                href='{{ url('actionlogout') }}'>LOGOUT</a></div>

                    </li>
                </ul>
            </div>
        </nav>
        <div class="main">
            <nav class="navbar navbar-expand navbar-theme">
                <a class="sidebar-toggle d-flex me-2">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown ms-lg-2 active">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown"
                                data-bs-toggle="dropdown">
                                <i class="align-middle fas fa-user"></i>
                                okey
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('actionlogout') }}"><i
                                        class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            {{-- isi main container --}}
            @yield('content')
            {{-- end isi main container --}}
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-12 text-end">
                            <p class="mb-0">
                                APKIS &copy; {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <svg width="0" height="0" style="position:absolute">
        <defs>
            <symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong">
                <path
                    d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z">
                </path>
            </symbol>
        </defs>
    </svg>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    @yield('scripts')

    <script>
        // fanction input angka
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
        }
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            var datatablesButtons = $("#datatables-buttons").DataTable({
                responsive: true,
                //lengthChange: !1,
                //buttons: ["copy", "print", "csv"]
            });
            datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");
            // Select2
            $(".select2").each(function() {
                $(this)
                    .wrap("<div class=\"position-relative\"></div>")
                    .select2({
                        placeholder: "PILIH",
                        dropdownParent: $(this).parent()
                    });
            });
            // datapiker
            $('#datetimepicker-view-mode').datetimepicker({
                viewMode: 'years'
            });
            $('#datetimepicker-view-mode2').datetimepicker({
                viewMode: 'years'
            });
            $('#datetimepicker-date').datetimepicker({
                format: 'L'
            });

        });
    </script>
    <script>
        function handleClick() {
            alert('Button clicked!');
        }
    </script>
</body>

</html>
