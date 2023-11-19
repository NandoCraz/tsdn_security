<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::paginate(10);

        return view('dokterPage.tableData', [
            'pasien' => $pasien
        ]);
    }

    public function detail($id)
    {
        $pasien = Pasien::find($id);

        return view('dokterPage.detailPasien', [
            'pasien' => $pasien
        ]);
    }
} 
