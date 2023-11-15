<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $authentication = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (auth()->attempt($authentication)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Login Berhasil, Halo ' . auth()->user()->name);
        }


        return back()->with('error', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        // dd($request->all());
        $id = auth()->user()->id;
        User::where('id', $id)->update([
            'is_active' => false
        ]);
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
