@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                   Seting Kop
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card">
                                <div class="card-body border-navy">
                                    <form class="row row-cols-md-auto align-items-center" id="dataForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                            <div class="col-12">
                                                <div class="input-group mb-2 me-sm-2">
                                                    <div class="input-group-text">File Kop</div>
                                                    <input type="file" class="form-control" name="file_kop" id="file_kop" >
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button type="button" id="saveBtn"
                                                    class="btn btn-primary mb-2 me-sm-2">Simpan</button>
                                            </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="card-body " style="text-align: center;">
                            <div id="loading-indicator" style="display:none;">Loading...</div>
                            <img id="view-image" src="" alt="Dynamic Image" width="300" height="200" style="display:none;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
    function loadImage() {
        const loadingIndicator = $('#loading-indicator');
        const viewImage = $('#view-image');

        // Show loading indicator
        loadingIndicator.show();
        viewImage.hide();

        $.ajax({
            url: '{{ url('admin/kop/ajax_view_kop') }}', // Replace with your API endpoint
            method: 'GET',
            dataType: 'json', // Expecting JSON response
            success: function(response) {
                const imageUrl = '{{ asset('storage/kop') }}/' +response.data.image_kop; // Adjust based on your JSON structure
                viewImage.attr('src', imageUrl).on('load', function() {
                    loadingIndicator.hide(); // Hide loading indicator
                    viewImage.show(); // Show the image
                });
            },
            error: function() {
                loadingIndicator.hide(); // Hide loading indicator
                alert('Failed to load image.');
            }
        });
    }

    // Example usage
    loadImage();

    // save dan update data
    $('#saveBtn').on('click', function() {
        var url = '{{ url('admin/kop/ajax_upload_kop') }}';
        var form = $('#dataForm')[0];
        var formData = new FormData(form);

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#dataForm')[0].reset();
                loadImage();
                Swal.fire({
                    title: response.success ? 'Success' : 'Error',
                    text: response.message,
                    icon: response.success ? 'success' : 'error',
                    confirmButtonText: 'OK'
                });
            },
            error: function(response) {
                Swal.fire({
                    title: response.success ? 'Success' : 'Error',
                    text: response.message,
                    icon: response.success ? 'success' : 'error',
                    confirmButtonText: 'OK'
                });

            }
        });
    });
    </script>
@endsection
