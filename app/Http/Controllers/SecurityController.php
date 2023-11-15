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
        return view('faceRecognation.index');
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
        $request->validate([
            'image' => 'required'
        ]);

        $user = User::where('id', $request->id)->first();

        // pecah kode dan masukkan pada storage
        $imgContent = $request->image;

        if (!file_exists(storage_path('app/face'))) {
            mkdir(storage_path('app/face'), 0755, true);
        }

        $file_path =  storage_path('app/face/' . time() . '.png');;
        Image::make(file_get_contents($imgContent))->save($file_path);

        $image1 = 'storage/' . $user->face_id;
        $image2 = $file_path;

        $imageComparator = new ImageComparator();

        $similarity = $imageComparator->compare($image1, $image2);

        // dd($similarity);

        if ($similarity > 40) {
            User::where('id', $request->id)->update([
                'is_active' => true
            ]);

            return redirect('/')->with('success', 'Selamat Datang ' . $user->name);
        } else {
            return redirect('/face-recognation')->with('error', 'Wajah Tidak Cocok');
        }
    }
}
