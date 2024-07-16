@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }

        .profile {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-item span.label {
            font-weight: bold;
            margin-right: 10px;
        }

        .profile-item span.separator {
            margin-right: 10px;
        }

        .profile-item span.value {
            margin-left: 10px;
        }
        .profile-item .value ol {
            margin: 0;
            padding-left: 10px;
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title" id="judul_header">
                    Data Rapor Kegiatan Peserta
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row border-navy">
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Tahun Ajaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="tahun_ajaran" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Rapor</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="rapor" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Jenjang</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="jenjang" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nama</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="siswa" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Kelas</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="kelas" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Pembimbing</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="pembimbing" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="text-center">
                                        <img alt="Peserta" id="avatarImg" src=""
                                            class="rounded-circle img-responsive" width="100" height="100" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-4 profile ">
                                    <span class="mb-3 d-flex justify-content-center" >HAFALAN BARU</span>
                                    <!-- tahfidz -->
                                    <div class="tahfidz-view-baru">
                                        <div class="profile-item  mb-3 d-flex justify-content-between" >
                                            <span class="label text-end" style="flex: 1;">Nilai Tajwid</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_j_baru" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item  mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Fasohah</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_f_baru" style="flex: 1;">-</span>
                                        </div>
                                    </div>
                                    <!-- tahsin -->
                                    <div class="tahsin-view-baru">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Gunnah</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_g_baru" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Mad</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_m_baru" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Waqaf</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_w_baru" style="flex: 1;">-</span>
                                        </div>
                                    </div>
                                    

                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Kelancaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_k_baru" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Rata-Rata Nilai</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="rata_baru" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Surah</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="surah_baru" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <span class="mb-3 d-flex justify-content-center" >HAFALAN LAMA</span>
                                    <div class="tahfidz-view-lama">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Tajwid</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_j_lama" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Fasohah</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_f_lama" style="flex: 1;">-</span>
                                        </div>
                                    </div>
                                    <!-- tahsin -->
                                    <div class="tahsin-view-lama">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Gunnah</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_g_lama" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Mad</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_m_lama" style="flex: 1;">-</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nilai Waqaf</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="n_w_lama" style="flex: 1;">-</span>
                                        </div>
                                    </div>

                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Kelancaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_k_lama" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Rata-Rata Nilai</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="rata_lama" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Surah</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="surah_lama" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <span class="mb-3 d-flex justify-content-center" >NILAI PENGEMBANGAN DIRI</span>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Keaktifan dan Kedisiplinan</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_k" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Murojaah Hafalan Mandiri</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_m" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Tilawah Al-Quran Mandiri</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_t" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Tahsin Al-Qur'an</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_th" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Tarjim / Tafhim Al-Quran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_tf" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nilai Jumlah Khatam Al-Qur'an</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="n_jk" style="flex: 1;">-</span>
                                    </div>
                                </div>
                            </div>
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
        var id = '{{ $id }}';
        var peserta = '{{ $peserta }}';
        var periode = '{{ $periode }}';
        var jenjang = '{{ $jenjang }}';
        var tahun = '{{ $tahun }}';

        $(".tahsin-view-baru").hide();
        $(".tahfidz-view-baru").hide();

        $(".tahsin-view-lama").hide();
        $(".tahfidz-view-lama").hide();
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function getRating(rata_baru) {
            if (rata_baru >= 80) {
                return "sangat baik"; // very good
            } else if (rata_baru >= 60) {
                return "baik"; // good
            } else if (rata_baru >= 40) {
                return "buruk"; // bad
            } else {
                return "sangat buruk"; // very bad
            }
        }
        $(document).ready(function() {
            // identitas
            $.ajax({
                url: '{{ url('peserta_rapor/ajax_detail_peserta') }}/' + id + '/' + peserta + '/' + tahun + '/' + jenjang + '/' + periode,
                type: 'GET',
                success: function(respons) {
                    console.log(respons);
                   // Ensure data.periode and its properties exist
                    var nama_tahun_ajaran = respons.data.nama_tahun_ajaran || '';
                    var jenis_kegiatan = respons.data.jenis_periode || '';
                    var nama_guru = respons.data.nama_guru || '';
                    var nama_siswa = respons.data.nama_siswa || '';
                    var nama_kelas = respons.data.nama_kelas || '';
                    var jenjang = respons.data.jenis_kegiatan || '';

                    // Update the HTML elements
                    $('#tahun_ajaran').text(capitalizeFirstLetter(nama_tahun_ajaran));
                    $('#rapor').text(capitalizeFirstLetter(jenis_kegiatan));
                    $('#pembimbing').text(capitalizeFirstLetter(nama_guru));
                    $('#siswa').text(capitalizeFirstLetter(nama_siswa));
                    $('#kelas').text(capitalizeFirstLetter(nama_kelas));
                    $('#jenjang').text(capitalizeFirstLetter(jenjang));
                    if (respons.data.foto_siswa != null) {
                        var fotoSiswaUrl = "{{ url('storage') }}/" + respons.data.foto_siswa;
                        $('#avatarImg').attr('src', fotoSiswaUrl);
                    } else {
                        var fotoSiswaUrl = '{{ asset('assets/admin/img/avatars/avatar.jpg') }}'
                        $('#avatarImg').attr('src', fotoSiswaUrl);
                    }
                    
                    if (jenis_kegiatan == 'tahfidz') {
                        // rapor tahfidz baru
                        var n_j_baru = respons.data.n_j_baru || 0;
                        var n_f_baru = respons.data.n_f_baru || 0;
                        var n_k_baru = respons.data.n_k_baru || 0;
                        var rata_baru = (n_j_baru+n_f_baru+n_k_baru)/3;
                        var rating_baru = getRating(rata_baru);
                        var rata_baru_rounded = rata_baru.toFixed(2) + " ( " + rating_baru + " )";
                        var surah_baru = respons.data.surah_baru || 0;
                        $('#n_j_baru').text( n_j_baru.toFixed(2) );
                        $('#n_f_baru').text( n_f_baru.toFixed(2) );
                        $('#n_k_baru').text( n_k_baru.toFixed(2) );
                        $('#rata_baru').text( rata_baru_rounded );

                        var $target = $('#surah_baru');
                        $target.empty();

                        if (surah_baru !== null && surah_baru.trim() !== '') {
                            var surahArray = surah_baru.split(',');
                            var $ol = $('<ol></ol>');
                            surahArray.forEach(function(surah) {
                                var $li = $('<li></li>').text(surah.trim());
                                $ol.append($li);
                            });
                            $target.append($ol);
                        } else {
                            $target.text('0');
                        }

                        // rapor tahfidz lama
                        var n_j_lama = respons.data.n_j_lama || 0;
                        var n_f_lama = respons.data.n_f_lama || 0;
                        var n_k_lama = respons.data.n_k_lama || 0;
                        var rata_lama = (n_j_lama+n_f_lama+n_k_lama)/3;
                        var rating_lama = getRating(rata_lama);
                        var rata_lama_rounded = rata_lama.toFixed(2) + " ( " + rating_lama + " )";
                        var surah_lama = respons.data.surah_lama || 0;
                        $('#n_j_lama').text(n_j_lama.toFixed(2));
                        $('#n_f_lama').text(n_f_lama.toFixed(2));
                        $('#n_k_lama').text(n_k_lama.toFixed(2));
                        $('#rata_lama').text(rata_lama_rounded);

                        var $target = $('#surah_lama');
                        $target.empty();

                        if (surah_lama !== null && surah_lama.trim() !== '') {
                            var surahArray = surah_lama.split(',');
                            var $ol = $('<ol></ol>');
                            surahArray.forEach(function(surah) {
                                var $li = $('<li></li>').text(surah.trim());
                                $ol.append($li);
                            });
                            $target.append($ol);
                        } else {
                            $target.text('0');
                        }

                        $(".tahfidz-view-baru").show();
                        $(".tahfidz-view-lama").show();
                    } else {
                        // rapor tahsin baru
                        var n_g_baru = respons.data.n_g_baru || null;
                        var n_m_baru = respons.data.n_m_baru || null;
                        var n_w_baru = respons.data.n_w_baru || null;
                        var n_k_baru = respons.data.n_k_baru || null;
                        var rata_baru = (n_g_baru+n_m_baru+n_w_baru+n_k_baru)/4;
                        var rating_baru = getRating(rata_baru);
                        var rata_baru_rounded = rata_baru.toFixed(2) + " ( " + rating_baru + " )";
                        var surah_baru = respons.data.surah_baru || null;
                        $('#n_g_baru').text(n_g_baru !== null ? n_g_baru.toFixed(2) : '00.00');
                        $('#n_m_baru').text(n_m_baru !== null ? n_m_baru.toFixed(2) : '00.00');
                        $('#n_w_baru').text(n_w_baru !== null ? n_w_baru.toFixed(2) : '00.00');
                        $('#n_k_baru').text(n_k_baru !== null ? n_k_baru.toFixed(2) : '00.00');
                        $('#rata_baru').text(n_k_baru !== null ? rata_baru_rounded : '00.00');
                        var $target = $('#surah_baru');
                        $target.empty();

                        if (surah_baru !== null && surah_baru.trim() !== '') {
                            var surahArray = surah_baru.split(',');
                            var $ol = $('<ol></ol>');
                            surahArray.forEach(function(surah) {
                                var $li = $('<li></li>').text(surah.trim());
                                $ol.append($li);
                            });
                            $target.append($ol);
                        } else {
                            $target.text('0');
                        }

                        // rapor tahsin lama
                        var n_g_lama = respons.data.n_g_lama || null;
                        var n_m_lama = respons.data.n_m_lama || null;
                        var n_w_lama = respons.data.n_w_lama || null;
                        var n_k_lama = respons.data.n_k_lama || null;
                        var rata_lama = (n_g_lama+n_m_lama+n_w_lama+n_k_lama)/4;
                        var rating_lama = getRating(rata_lama);
                        var rata_lama_rounded = rata_lama.toFixed(2) + " ( " + rating_lama + " )";
                        var surah_lama = respons.data.surah_lama || null;
                        $('#n_g_lama').text(n_g_lama !== null ? n_g_lama.toFixed(2) : '00.00');
                        $('#n_m_lama').text(n_m_lama !== null ? n_m_lama.toFixed(2) : '00.00');
                        $('#n_w_lama').text(n_w_lama !== null ? n_w_lama.toFixed(2) : '00.00');
                        $('#n_k_lama').text(n_k_lama !== null ? n_k_lama.toFixed(2) : '00.00');
                        $('#rata_lama').text(n_k_lama !== null ? rata_lama_rounded : '00.00');
                        var $target = $('#surah_lama');
                        $target.empty();

                        if (surah_lama !== null && surah_lama.trim() !== '') {
                            var surahArray = surah_lama.split(',');
                            var $ol = $('<ol></ol>');
                            surahArray.forEach(function(surah) {
                                var $li = $('<li></li>').text(surah.trim());
                                $ol.append($li);
                            });
                            $target.append($ol);
                        } else {
                            $target.text('0');
                        }

                        $(".tahsin-view-baru").show();
                        $(".tahsin-view-lama").show();
                    }

                    

                    // nilai pengembangan diri
                    var n_k_p = respons.data.n_k_p || 0;
                    var n_m_p = respons.data.n_m_p || 0;
                    var n_t_p = respons.data.n_t_p || 0;
                    var n_th_p = respons.data.n_th_p || 0;
                    var n_tf_p = respons.data.n_tf_p || 0;
                    var n_jk_p = respons.data.n_jk_p || 0;

                    $('#n_k').text(n_k_p.toFixed(2));
                    $('#n_m').text(n_m_p.toFixed(2));
                    $('#n_t').text(n_t_p.toFixed(2));
                    $('#n_th').text(n_th_p.toFixed(2));
                    $('#n_tf').text(n_tf_p.toFixed(2));
                    $('#n_jk').text(n_jk_p.toFixed(2));


                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        });
    </script>
@endsection
