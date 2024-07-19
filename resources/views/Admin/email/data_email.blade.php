@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">

            <div class="header">
                <h1 class="header-title">
                    Seting Mail
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form method="POST" id="dataForm" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h5 class="card-title mb-0">Info Seting Email </h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputUsername">Mailer</label>
                                            <input type="text" class="form-control" name="mail_mailer" id="mail_mailer" 
                                                value="{{ $email->mail_mailer ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Host</label>
                                            <input type="text" class="form-control" name="mail_host" id="mail_host" 
                                                value="{{ $email->mail_host ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Port</label>
                                            <input type="text" class="form-control" name="mail_port" id="mail_port" 
                                                onkeypress="return hanyaAngka(event)" value="{{ $email->mail_port ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Username</label>
                                            <input type="text" class="form-control" name="mail_username" id="mail_username" 
                                                value="{{ $email->mail_username ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputUsername">Password</label>
                                            <div class="input-group date" id="password-view"
                                                data-target-input="nearest">
                                                <input type="password" class="form-control " id="password" name="mail_password"
                                                    data-target="#password-view" placeholder="password" value="{{ $email->mail_password ?? '' }}" required/>
                                                <div class="input-group-text" onclick="togglePasswordVisibility()"><i class="fas fa-eye" id="toggle-icon"></i></div>
                                            </div>
                                            <small class="text-danger">Password dari seting email app google.com/server</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Encryption</label>
                                            <input type="text" class="form-control" name="mail_encryption" id="mail_encryption" 
                                                value="{{ $email->mail_encryption ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Alamat Email</label>
                                            <input type="text" class="form-control" name="mail_from_address" id="mail_from_address" 
                                                value="{{ $email->mail_from_address ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Nama Sistem/Aplikasi</label>
                                            <input type="text" class="form-control" name="mail_from_name" id="mail_from_name" 
                                                value="{{ $email->mail_from_name ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <button type="button" onclick="toggleInputs()" class="btn btn-warning">Edit Data</button>
                                <button type="button" id="submitBtn" class="btn btn-primary">Update Email</button>
                                <button type="button" id="testBtn" class="btn btn-secondary">Test Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
        document.getElementById("submitBtn").disabled = true;
        var inputs = ['mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption',
            'mail_from_address', 'mail_from_name'
        ];
        inputs.forEach(function(id) {
            var inputField = document.getElementById(id);
            if (inputField) {
                inputField.readOnly = !inputField.readOnly;
            }
        });
        
        function toggleInputs() {
            document.getElementById("submitBtn").disabled = false;
            var inputs = ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption',
                'mail_from_address', 'mail_from_name'
            ];
            inputs.forEach(function(id) {
                var inputField = document.getElementById(id);
                if (inputField) {
                    inputField.readOnly = !inputField.readOnly;
                }
            });
        }

        // save harga
        $('#submitBtn').on('click', function() {
            var id = '{{ $email->id}}';
            var url = '{{ url('admin/mail/ajax_update_mail') }}/' + id;
            Swal.fire({
                title: 'Loading...',
                text: 'Jangan tutup halaman ini.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#dataForm').serialize(),
                success: function(response) {
                    Swal.close();
                    document.getElementById("submitBtn").disabled = true;
                    Swal.fire({
                        title: 'Success!',
                        text: response.massage,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.massage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function togglePasswordVisibility() {
                var passwordField = document.getElementById("password");
                var toggleIcon = document.getElementById("toggle-icon");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.remove("fa-eye");
                    toggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.remove("fa-eye-slash");
                    toggleIcon.classList.add("fa-eye");
                }
            }

        //view password
        $('#toggle-icon').on('click', togglePasswordVisibility);

        // test mail
        $('#testBtn').on('click', function() {
            var mailFromAddress = document.getElementById('mail_from_address').value.trim();
            var url = '{{ url('admin/mail/ajax_test_mail') }}/' + mailFromAddress;
            if (mailFromAddress === '') {
                alert('Mail From Address cannot be empty.');
            }else{
                Swal.fire({
                    title: 'Loading...',
                    text: 'Jangan tutup halaman ini.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#dataForm').serialize(),
                    success: function(response) {
                        Swal.close();
                        Swal.fire({
                            title: 'Success!',
                            text: response.massage,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.massage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

        });
    </script>
@endsection
