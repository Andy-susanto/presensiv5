<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Presensi | UIN JAMBI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- include the site stylesheet -->
    <link
        href="https://fonts.googleapis.com/css?family=Arizonia%7COpen+Sans:300,300i,400,400i,600,700,800%7CRoboto:300,400,500,700"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style type="text/css">
        #results {
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }

        #header.style2 .header-area {
            background-image: url("{{ asset('assets/images/header.svg') }}");
            background-repeat: no-repeat;
            background-size: 100%;
            background-color: #3F59E2;
        }
    </style>

</head>

<body>
    <!-- main container of all the page elements -->
    <div id="wrapper">
        <!-- header of the page -->
        <header id="header" class="style2">
            <!-- header area of the page -->
            <div class="header-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="contact-list list-unstyled">
                                <li><i class="icon fa fa-clock-o"></i>Jam Sekarang :
                                    <center>
                                        <h3 style="font-size: 80px; font-family: arial; color:white" id="jam">
                                        </h3>
                                    </center>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- main of the page -->
        <main id="main">
            <!-- banner of the page -->
            <section class="banner bg-full">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 text-center">
                            <h1 class="text-center">PRESENSI UIN SULTHAN THAHA SAIFUDDIN JAMBI</h1>
                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div id="my_camera"></div>
                                        <br />
                                        <input type="hidden" name="image" class="image-tag" required>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div id="results">Foto Presensi</div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Nama Pegawai</label>
                                            <select class="form-control select2" name="" id="pegawai_id"
                                                required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <br />
                                        <button type="button" class="btn btn-success"
                                            onClick="take_snapshot()">Presensi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- loader of the page -->
        <div id="loader" class="loader-holder">
            <div class="block"><img src="{{ asset('assets/images/svg/hearts.svg') }}" width="100" alt="loader">
            </div>
        </div>
    </div>
    </div>
    <!-- include jQuery -->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- include jQuery -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- include jQuery -->
    <script src="{{ asset('assets/js/jquery.main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
    <script language="JavaScript">
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Cari Pegawai..",
                ajax: {
                    url: "{{ route('load.pegawai') }}",
                    dataTyper: "json",
                    data: function(param) {
                        var value = {
                            search: param.term,
                        }
                        return value;
                    },
                    processResults: function(hasil) {

                        return {
                            results: hasil,
                        }
                    }
                }
            });
        });
        Webcam.set({
            width: 500,
            height: 400,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function take_snapshot() {
            var pegawai = $("#pegawai_id").val();
            if (pegawai != null) {
                Webcam.snap(function(data_uri) {
                    $(".image-tag").val(data_uri);
                    document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                });
                var foto = $(".image-tag").val();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "{{ route('presensi.store') }}",
                    data: {
                        pegawai_id: pegawai,
                        foto_presensi: foto
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                        $('.select2').val('')
                        $('#results').html('Foto Presensi')
                    }
                })
            } else {
                toastr.error('Anda Belum memilih pegawai ');
            }
        }
    </script>
</body>

</html>
