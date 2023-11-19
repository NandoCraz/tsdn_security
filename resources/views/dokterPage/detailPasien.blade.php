@extends('dokterPage.layouts.main')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Detail Pasien
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <h5>Nama: {{ $pasien->nama }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Umur: {{ $pasien->usia }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Kategori: {{ $pasien->pekerjaan }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Jenis Kelamin: {{ $pasien->jenis_kelamin }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Penyakit: {{ $pasien->diagnosa }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Dokter Menangani: {{ $pasien->nama_dokter }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Kota: {{ $pasien->kota }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Tanggal Masuk: {{ $pasien->tgl_masuk }}</h5>
                    </div>
                    <div class="col-md-6 mt-4">
                        <h5>Tanggal Keluar: {{ $pasien->tgl_keluar }}</h5>
                    </div>
                </div>
                <a href="/data-pasien" class="btn btn-sm btn-secondary mt-5">Kembali</a>
            </div>
        </div>
    </div>
@endsection
