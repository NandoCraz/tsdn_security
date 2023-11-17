<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SapientPro\ImageComparator\ImageComparator;
use Intervention\Image\Facades\Image;

class SecurityController extends Controller
{
    public function index()
    {
        $api_token = env('API_TOKEN');
        return view('faceRecognation.index', [
            'api_token' => $api_token
        ]);
    }

    public function checkActive(Request $request)
    {
        User::where('id', $request->id)->update([
            'is_active' => false
        ]);

        return redirect('/face-recognation');
    }

    public function faceCheck(Request $request)
    {
        User::where('id', $request->id)->update([
            'is_active' => true
        ]);

        return redirect('/')->with('success', 'Selamat datang!');
    }
}
