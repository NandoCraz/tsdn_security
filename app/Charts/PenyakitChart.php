<?php

namespace App\Charts;
use App\Models\Pasien;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;


class PenyakitChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $penyakits = DB::table('pasiens')->select('diagnosa')->distinct()->pluck('diagnosa')->toArray();
        foreach ($penyakits as $namaPenyakit) {
            $jumlahPasien = DB::table('pasiens')->where('diagnosa', $namaPenyakit)->count();
            $jumlahPasienPerPenyakit[] = $jumlahPasien;
        }
        // $jumlahPasienPerPenyakit = [];
        // foreach ($pasiens as $penyakit) {
        //     // Jika nama penyakit sudah ada di array, tambahkan jumlah pasien
        //     if (array_key_exists($penyakit, $jumlahPasienPerPenyakit)) {
        //         $jumlahPasienPerPenyakit[$penyakit]++;
        //     } else {
        //         // Jika nama penyakit belum ada di array, tambahkan ke array dengan jumlah 1
        //         $jumlahPasienPerPenyakit[$penyakit] = 1;
        //     }
        // }
        // dd($pasiens);
        // dd($penyakits);
        return $this->chart->lineChart()
            ->setTitle('Penyakit')
            ->setSubtitle('per pasien')
            // ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Jumlah Pasien', $jumlahPasienPerPenyakit)
            ->setColors(['#102D3C'])
            ->setHeight(300)
            ->setXAxis($penyakits);
    }
}
