<?php

namespace App\Http\Controllers;

use App\Charts\PenyakitChart;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(PenyakitChart $chart)
    {
        $pasien = Pasien::all();
        $penyakits = DB::table('pasiens')->select('diagnosa', DB::raw('count(*) as total'))->groupBy('diagnosa')->get();
        $lansia = Pasien::where('pekerjaan', 'lansia');
        $dewasa = Pasien::where('pekerjaan', 'dewasa');
        $remaja = Pasien::where('pekerjaan', 'remaja');
        $anak = Pasien::where('pekerjaan', 'anak');

        // dd($penyakits);

        return view('dokterPage.dashboard', [
            'pasien' => $pasien,
            'penyakits' => $penyakits,
            'anak' => $anak,
            'remaja' => $remaja,
            'dewasa' => $dewasa,
            'lansia' => $lansia,
            'chart' => $chart->build()
        ]);;
    }
}
