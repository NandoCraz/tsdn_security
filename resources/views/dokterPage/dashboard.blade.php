@extends('dokterPage.layouts.main')
@section('content')
<div class="container mb-4 text-center">
    <h2 class="fw-bolder" style="font-weight: bold">Halo! {{ auth()->user()->name }}...</h2>
    <div class="row mt-3">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid yellowgreen">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: yellowgreen">
                                Total Pasien
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pasien->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid rgb(255, 17, 0)">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgb(255, 17, 0)">
                                Total Penyakit (Seluruh)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penyakits->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-wheelchair fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid rgb(151, 134, 34)">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgb(151, 134, 34)
                            ">
                                Pasien Lansia
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lansia->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-blind fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid rgb(30, 167, 137)">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgb(30, 167, 137)">
                                Pasien Dewasa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dewasa->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid rgb(0, 68, 255)">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgb(0, 68, 255)">
                                Pasien Remaja
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $remaja->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid rgb(233, 68, 233)"> 
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgb(233, 68, 233)">
                                Pasien Anak-anak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $anak->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card shadow h-100">
                <div class="card shadow h-100 py-2" style="border-left: 4px solid #103c10">
                    <div class="card-body">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ $chart->cdn() }}"></script>

        {{ $chart->script() }}

        
@endsection
@section('script')
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
@endsection