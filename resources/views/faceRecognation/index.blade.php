<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Face Recognition</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets_login/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets_login/img/logo_ukk.png') }}">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets_login/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style type="text/css">
        #results {
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }
    </style>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
</head>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    {{-- @if (session()->has('berhasil'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <h5>{{ session('berhasil') }}</h5>
                        </div>
                    @endif
                    @if (session()->has('gagal'))
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <h5>{{ session('gagal') }}</h5>
                        </div>
                    @endif --}}

                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="col-md-6">
                                    <div id="results" class="d-flex justify-content-center align-items-center rounded"
                                        style="width: 400px;">Your captured image will appear
                                        here...</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="my_camera"></div>
                                <br />
                                <div class="d-flex w-100 justify-content-center">
                                    <input type=button class="btn btn-secondary btn-sm" value="Take Photo"
                                        onClick="take_snapshot()">
                                </div>
                                <input type="hidden" name="image" type="file" class="image-tag">
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                            </div>
                            <div class="col-lg-12 d-flex my-4 justify-content-center">
                                <button type="button" onclick="javascript:check_similarity()"
                                    class="btn btn-sm btn-success">Check</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets_login/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_login/js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('assets_login/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets_login/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets_login/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets_login/vendor/chart.js/Chart.min.js') }} "></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets_login/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets_login/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '" width="350" />';
            });
        }

        var person_uuid = null
        var API_TOKEN = `{{ $api_token }}`
        var face_base = `{{ 'storage/' . auth()->user()->foto }}`

        function similarity(face1, face2, callback) {
            var myHeaders = new Headers();
            myHeaders.append("token", API_TOKEN);

            var formdata = new FormData();

            if ((typeof face1 == "string") && (face1.indexOf("https://") == 0))
                formdata.append("face1", face1);
            else
                formdata.append("face1", face1);

            if ((typeof face2 == "string") && (face2.indexOf("https://") == 0))
                formdata.append("face2", face2);
            else
                formdata.append("face2", face2);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: formdata,
                redirect: 'follow'
            };

            fetch("https://api.luxand.cloud/photo/landmarks", requestOptions)
                .then(response => response.json())
                .then(result => callback(result))
                .catch(error => console.log('error', error));
        }

        function check_similarity() {
            var face1 = face_base;
            var face2 = $(".image-tag").val();

            similarity(face1, face2, function(result) {
                console.log(result);
            });
        }
    </script>

    {{-- <script>
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '" width="350" />';
            });
        }
        
        var person_uuid = null
        var API_TOKEN = `{{ $api_token }}`

        function add_person(name, image, collections, callback) {
            var myHeaders = new Headers();
            myHeaders.append("token", API_TOKEN);

            var formdata = new FormData();
            formdata.append("name", name);

            if ((typeof image == "string") && (image.indexOf("https://") == 0))
                formdata.append("photos", image);
            else
                formdata.append("photos", image, "file");

            formdata.append("store", "1");
            formdata.append("collections", collections);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: formdata,
                redirect: 'follow'
            };

            fetch("https://api.luxand.cloud/v2/person", requestOptions)
                .then(response => response.json())
                .then(result => callback(result))
                .catch(error => console.log('error', error));
        }

        // function add_face(person_uuid, image, callback) {
        //     var myHeaders = new Headers();
        //     myHeaders.append("token", API_TOKEN);

        //     var formdata = new FormData();

        //     if ((typeof image == "string") && (image.indexOf("https://") == 0))
        //         formdata.append("photos", image);
        //     else
        //         formdata.append("photos", image, "file");

        //     formdata.append("store", "1");

        //     var requestOptions = {
        //         method: 'POST',
        //         headers: myHeaders,
        //         body: formdata,
        //         redirect: 'follow'
        //     };

        //     fetch("https://api.luxand.cloud/v2/person/" + person_uuid, requestOptions)
        //         .then(response => response.json())
        //         .then(result => callback(result))
        //         .catch(error => console.log('error', error));
        // }

        function verify(person_uuid, image, callback) {
            var myHeaders = new Headers();
            myHeaders.append("token", API_TOKEN);

            var formdata = new FormData();

            if ((typeof image == "string") && (image.indexOf("https://") == 0))
                formdata.append("photo", image);
            else
                formdata.append("photo", image, "file");

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: formdata,
                redirect: 'follow'
            };

            fetch("https://api.luxand.cloud/photo/verify/" + person_uuid, requestOptions)
                .then(response => response.json())
                .then(result => callback(result))
                .catch(error => console.log('error', error));
        }

        function upload_person() {
            var face = {{ 'storage/' . auth()->user()->foto }}
            name = `{{ auth()->user()->name }}`

            add_person(name, face, "", function(result) {
                if (result.status == "success") {
                    // document.getElementById("person_id").innerHTML = result["uuid"]
                    person_uuid = result["uuid"]
                }
            });
        }

        function verify_person() {
            var photo = document.getElementsByName("image");
            console.log(photo);

            // verify(person_uuid, photo, function(result) {
            //     console.log(result["message"])
            //     // document.getElementById("verification_status").innerHTML = result["message"]
            //     // document.getElementsByClassName("recognize-result")[0]["style"]["display"] = "block"
            // });
        }
    </script> --}}

    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal
                        .stopTimer)
                    toast.addEventListener('mouseleave', Swal
                        .resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            }).then((result) => {
                location.reload();
            })
        </script>
    @endif
    @if (session('error'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal
                        .stopTimer)
                    toast.addEventListener('mouseleave', Swal
                        .resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            }).then((result) => {
                location.reload();
            })
        </script>
    @endif
</body>

</html>
