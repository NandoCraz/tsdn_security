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
                        <form action="/face-check" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="col-md-6">
                                        <div id="results"
                                            class="d-flex justify-content-center align-items-center rounded"
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
                                    <button type="submit" class="btn btn-sm btn-success">Check</button>
                                </div>
                            </div>
                        </form>
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
    </script>

    <script>
        "use strict";

        const msRest = require("@azure/ms-rest-js");
        const Face = require("@azure/cognitiveservices-face");
        const {
            v4: uuid
        } = require("uuid");

        const key = process.env.FACE_API_KEY;
        const endpoint = process.env.FACE_API_ENDPOINT;

        const credentials = new msRest.ApiKeyCredentials({
            inHeader: {
                "Ocp-Apim-Subscription-Key": key,
            },
        });
        const client = new Face.FaceClient(credentials, endpoint);

        const image_base_url =
            "https://raw.githubusercontent.com/Azure-Samples/cognitive-services-sample-data-files/master/Face/images/";
        const person_group_id = uuid();

        function sleep(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        }

        async function DetectFaceRecognize(url) {
            // Detect faces from image URL. Since only recognizing, use the recognition model 4.
            // We use detection model 3 because we are only retrieving the qualityForRecognition attribute.
            // Result faces with quality for recognition lower than "medium" are filtered out.
            let detected_faces = await client.face.detectWithUrl(url, {
                detectionModel: "detection_03",
                recognitionModel: "recognition_04",
                returnFaceAttributes: ["QualityForRecognition"],
            });
            return detected_faces.filter(
                (face) =>
                face.faceAttributes.qualityForRecognition == "high" ||
                face.faceAttributes.qualityForRecognition == "medium"
            );
        }

        async function AddFacesToPersonGroup(person_dictionary, person_group_id) {
            console.log("Adding faces to person group...");
            // The similar faces will be grouped into a single person group person.

            await Promise.all(
                Object.keys(person_dictionary).map(async function(key) {
                    const value = person_dictionary[key];

                    let person = await client.personGroupPerson.create(
                        person_group_id, {
                            name: key,
                        }
                    );
                    console.log("Create a persongroup person: " + key + ".");

                    // Add faces to the person group person.
                    await Promise.all(
                        value.map(async function(similar_image) {
                            // Wait briefly so we do not exceed rate limits.
                            await sleep(1000);

                            // Check if the image is of sufficent quality for recognition.
                            let sufficientQuality = true;
                            let detected_faces = await client.face.detectWithUrl(
                                image_base_url + similar_image, {
                                    returnFaceAttributes: ["QualityForRecognition"],
                                    detectionModel: "detection_03",
                                    recognitionModel: "recognition_03",
                                }
                            );
                            detected_faces.forEach((detected_face) => {
                                if (
                                    detected_face.faceAttributes
                                    .qualityForRecognition != "high"
                                ) {
                                    sufficientQuality = false;
                                }
                            });

                            // Wait briefly so we do not exceed rate limits.
                            await sleep(1000);

                            // Quality is sufficent, add to group.
                            if (sufficientQuality) {
                                console.log(
                                    "Add face to the person group person: (" +
                                    key +
                                    ") from image: " +
                                    similar_image +
                                    "."
                                );
                                await client.personGroupPerson.addFaceFromUrl(
                                    person_group_id,
                                    person.personId,
                                    image_base_url + similar_image
                                );
                            }
                            // Wait briefly so we do not exceed rate limits.
                            await sleep(1000);
                        })
                    );
                })
            );

            console.log("Done adding faces to person group.");
        }

        async function WaitForPersonGroupTraining(person_group_id) {
            // Wait so we do not exceed rate limits.
            console.log("Waiting 10 seconds...");
            await sleep(10000);
            let result = await client.personGroup.getTrainingStatus(person_group_id);
            console.log("Training status: " + result.status + ".");
            if (result.status !== "succeeded") {
                await WaitForPersonGroupTraining(person_group_id);
            }
        }

        /* NOTE This function might not work with the free tier of the Face service
                because it might exceed the rate limits. If that happens, try inserting calls
                to sleep() between calls to the Face service.
                */
        async function IdentifyInPersonGroup() {
            console.log("========IDENTIFY FACES========");
            console.log();

            // Create a dictionary for all your images, grouping similar ones under the same key.
            const person_dictionary = {
                "Family1-Dad": ["Family1-Dad1.jpg", "Family1-Dad2.jpg"],
                "Family1-Mom": ["Family1-Mom1.jpg", "Family1-Mom2.jpg"],
                "Family1-Son": ["Family1-Son1.jpg", "Family1-Son2.jpg"],
                "Family1-Daughter": ["Family1-Daughter1.jpg", "Family1-Daughter2.jpg"],
                "Family2-Lady": ["Family2-Lady1.jpg", "Family2-Lady2.jpg"],
                "Family2-Man": ["Family2-Man1.jpg", "Family2-Man2.jpg"],
            };

            // A group photo that includes some of the persons you seek to identify from your dictionary.
            let source_image_file_name = "identification1.jpg";

            // Create a person group.
            console.log("Creating a person group with ID: " + person_group_id);
            await client.personGroup.create(person_group_id, person_group_id, {
                recognitionModel: "recognition_04",
            });

            await AddFacesToPersonGroup(person_dictionary, person_group_id);

            // Start to train the person group.
            console.log();
            console.log("Training person group: " + person_group_id + ".");
            await client.personGroup.train(person_group_id);

            await WaitForPersonGroupTraining(person_group_id);
            console.log();

            // Detect faces from source image url and only take those with sufficient quality for recognition.
            let face_ids = (
                await DetectFaceRecognize(image_base_url + source_image_file_name)
            ).map((face) => face.faceId);

            // Identify the faces in a person group.
            let results = await client.face.identify(face_ids, {
                personGroupId: person_group_id,
            });
            await Promise.all(
                results.map(async function(result) {
                    try {
                        let person = await client.personGroupPerson.get(
                            person_group_id,
                            result.candidates[0].personId
                        );

                        console.log(
                            "Person: " +
                            person.name +
                            " is identified for face in: " +
                            source_image_file_name +
                            " with ID: " +
                            result.faceId +
                            ". Confidence: " +
                            result.candidates[0].confidence +
                            "."
                        );

                        // Verification:
                        let verifyResult = await client.face.verifyFaceToPerson(
                            result.faceId,
                            person.personId, {
                                personGroupId: person_group_id,
                            }
                        );
                        console.log(
                            "Verification result between face " +
                            result.faceId +
                            " and person " +
                            person.personId +
                            ": " +
                            verifyResult.isIdentical +
                            " with confidence: " +
                            verifyResult.confidence
                        );
                    } catch (error) {
                        //console.log("no persons identified for face with ID " + result.faceId);
                        console.log(error.toString());
                    }
                })
            );
            console.log();
        }

        async function main() {
            await IdentifyInPersonGroup();
            console.log("Done.");
        }
        main();
    </script>

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
