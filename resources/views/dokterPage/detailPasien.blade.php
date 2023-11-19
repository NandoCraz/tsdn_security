@extends('dokterPage.layouts.main')
@section('content')
    <div class="container">
        <!-- Your code for the detail pasien section goes here -->
        <h1>Detail Pasien</h1>
        <div class="row">
            <div class="col-md-6 mt-4">
                <h5>Nama: {{ $pasien->nama }}</h5>
            </div>
            <div class="col-md-6 mt-4">
                <h5>Umur: {{ $pasien->usia }}</h5>
            </div>
            <div class="col-md-6 mt-4">
                <h5>Alamat: {{ $pasien->pekerjaan }}</h5>
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
@endsection
