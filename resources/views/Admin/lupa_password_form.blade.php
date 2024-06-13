<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
    <meta name="author" content="Bootlab">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>APKIS</title>
    <style>
        body {
            opacity: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src=" {{ asset('assets/admin/js/settings.js') }}"></script>
    <link href=" {{ asset('assets/admin/css/modern.css') }}" type="text/css" rel="stylesheet">
</head>
<!-- SET YOUR THEME -->

<body class="theme-blue">
    @include('sweetalert::alert')
    <div class="splash active">
        <div class="splash-icon"></div>
    </div>

    <main class="main h-100 w-100 ">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-sm-10 col-md-8 col-lg-4 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/admin/img/icon_apkis.png') }}" alt="apkis"
                                            class="img-fluid rounded-circle" width="132" height="132" />
                                    </div>
                                    <div class="text-center mt-2">
                                        <p class="lead">
                                            MASUKAN PASSWORD BARU
                                        </p>
                                    </div>
                                    <form action="" method="POST" id="dataForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <div class="input-group date" id="password-view"
                                                        data-target-input="nearest">
                                                        <input type="password" class="form-control " id="password"
                                                            name="password" data-target="#password-view"
                                                            placeholder="Password Baru Anda" required />
                                                        <div class="input-group-text"
                                                            onclick="togglePasswordVisibility()"><i class="fas fa-eye"
                                                                id="toggle-icon"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a class='btn btn-lg btn-secondary' href='{{ url('/') }}'>Masuk</a>
                                            <button type="button" class="btn btn-lg btn-primary saveBTN"
                                                id="saveBTN">SELANJUTNYA</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <svg width="0" height="0" style="position:absolute">
        <defs>
            <symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong">
                <path
                    d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z">
                </path>
            </symbol>
        </defs>
    </svg>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
    <script src=" {{ asset('assets/admin/js/app.js') }}"></script>
    <script>
        // fanction input angka
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        //save pembelian
        $('#saveBTN').on('click', function() {
            var password = document.getElementById('password').value;
            var id = '{{ $id }}';
            var id_pelanggan = '{{ $id_pelanggan }}'
            var url = '{{ url('lupa_password/update_password_store') }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id: id,
                    id_pelanggan: id_pelanggan,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: "Silahkan Cek Email Anda",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open('/',
                                '_self'); // '_self' untuk membuka di tab atau jendela saat ini
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Email Tidak Terdaftar',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
</body>

</html>
