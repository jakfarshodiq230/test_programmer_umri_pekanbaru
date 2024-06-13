@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">

            <div class="header">
                <h1 class="header-title">
                    Seting Email
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
                                            <input type="text" class="form-control" name="mail_mailer"
                                                id="mail_mailer" value="{{$email->mail_mailer}}"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Host</label>
                                            <input type="text" class="form-control" name="mail_host"
                                                id="mail_host" value="{{$email->mail_host}}"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Port</label>
                                            <input type="text" class="form-control" name="mail_port" id="mail_port"
                                                onkeypress="return hanyaAngka(event)" value="{{$email->mail_port}}"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Username</label>
                                            <input type="text" class="form-control" name="mail_username"
                                                id="mail_username" value="{{$email->mail_username}}"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputUsername">Password</label>
                                            <input type="text" class="form-control" name="mail_password"
                                                id="mail_password" value="{{$email->mail_password}}"></input>
                                            <small class="text-danger" >Password dari seting email app google.com</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Encryption</label>
                                            <input type="text" class="form-control" name="mail_encryption"
                                                id="mail_encryption" value="{{$email->mail_encryption}}"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Alamat Email</label>
                                            <input type="text" class="form-control" name="mail_from_address"
                                                id="mail_from_address" value="{{$email->mail_from_address}}"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputUsername">Nama Email</label>
                                            <input type="text" class="form-control" name="mail_from_name"
                                                id="mail_from_name" value="{{$email->mail_from_name}}"></input>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" onclick="toggleInputs()" class="btn btn-warning">Edit Data</button>
                                <button type="button" id="submitBtn" class="btn btn-primary">Update Email</button>
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
            inputField.readOnly = !inputField.readOnly;
        });

        function toggleInputs() {
            document.getElementById("submitBtn").disabled = false;
            var inputs = ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption',
                'mail_from_address', 'mail_from_name'
            ];
            inputs.forEach(function(id) {
                var inputField = document.getElementById(id);
                inputField.readOnly = !inputField.readOnly;
            });
        }
        // save harga
        $('#submitBtn').on('click', function() {
            var id = '{{ $email->id}}';
            var url = '{{ url('email/update_email') }}/' + id;
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#dataForm').serialize(),
                success: function(response) {
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
    </script>
@endsection
