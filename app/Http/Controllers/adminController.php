<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Models\User;
use App\Models\member;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        session()->forget('draft_transaksi');
        $user = Auth::user();
        $member = $user->member;
        $outlets = Outlet::all();
        $temp_outlets = session('temp_outlets', []);
        return view('admin.index', compact('user','member','outlets', 'temp_outlets'));
    
    }
    public function dasboard()
    {
        $outletId = auth()->user()->outlet_id;

        $totalpetugas = User::where('role', 'petugas')
            ->where('outlet_id', $outletId)
            ->count();
        
            $totalmember = member::where('midtrans_payment_status', 'paid')
            ->where('outlet_id', $outletId)
            ->count();
    
            $totalPengguna = User::where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->count();

        return view('admin.dasboard', compact('totalPengguna','totalmember','totalpetugas'));
    
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
    
    function logout(){
        Auth::logout();
        return redirect('/');
    }

    
}
