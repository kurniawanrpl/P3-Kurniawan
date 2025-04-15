<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    function logintampil()
    {
       
        return view('admin.login');
    }
    function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'

        ],[
            'email.required'=>'email wajib di isi',
            'password.required'=>'password wajib di isi',
        ]);
        $infologin =[
            'email'=>$request->email,
            'password'=>$request->password,

        ];
        if (Auth::attempt($infologin)) {
           if (Auth::user()->role == 'admin') {
           return redirect('admin/dasboard');
           }elseif (Auth::user()->role == 'pengguna') {
            return redirect('admin/dasboard');
            }elseif (Auth::user()->role == 'supervisor') {
                return redirect('admin/dasboard');
                }elseif (Auth::user()->role == 'petugas') {
                    return redirect('admin/dasboard');
                    }elseif (Auth::user()->role == 'teknisi') {
                        return redirect('admin/dasboard');
                        }
        }else {
            return redirect('admin/login')->withErrors('username dan password salah')->withInput();
        }
    }
    function dasboard()
    {
        return view('admin.dasboard');
    }
    function logout(){
        Auth::logout();
        return redirect('/');
    }
}
