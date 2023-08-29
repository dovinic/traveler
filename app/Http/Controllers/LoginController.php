<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login_proses(Request $request) {
        $request->validate([
            'nama'      => 'required',
            'password'  => 'required',
        ]);

        $data = [
            'name'      => $request->nama,
            'password'  => $request->password,
        ];

        $namauser = User::where('name', $data['name'])->first();

        if($namauser) {
            session(['username' => $namauser->name]);
        }

        if(Auth::attempt($data)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('login')->with('failed','User atau Password Salah!');
        };

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success', "Kamu Berhasil Logout");
    }
}
