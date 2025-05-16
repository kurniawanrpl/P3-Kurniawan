<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\userController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\useradminController;
use App\Http\Controllers\userkaryawanController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PromoMemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\PaketLaundryController;
use Midtrans\Config;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
   
   
    Route::get('/', function () {
        Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
   
        return view('landing.landing'); // Halaman landing page
    })->name('landing');
   

});


Route::middleware('auth')->group(function () {
    Route::get('dasboard', function () {
        return view('admin.dasboard'); // Halaman setelah login
    })->name('dashboard');
    Route::get('home', function () {
        if (Auth::user()->role == 'admin') {
            return redirect('dasboard');
            }elseif (Auth::user()->role == 'supervisor') {
             return redirect('dasboard');
             }elseif (Auth::user()->role == 'petugas') {
                return redirect('dasboard');
                }elseif (Auth::user()->role == 'owner') {
                    return redirect('dasboard');
                    }elseif (Auth::user()->role == 'pengguna') {
                        return redirect('dasboard');
                        }
    
                    
    });
   //outlet
    Route::get('/outlets', [OutletController::class, 'index'])->name('outlets.index');
    Route::post('/outlets', [OutletController::class, 'store'])->name('outlets.store');
    Route::post('/outlets/simpan', [OutletController::class, 'simpan'])->name('outlets.simpan');
    Route::get('/outlets/edit/{id}', [OutletController::class, 'edit'])->name('outlets.edit');
    Route::put('/outlets/update/{id}', [OutletController::class, 'update'])->name('outlets.update');
    Route::delete('/outlets/delete/{id}', [OutletController::class, 'destroy'])->name('outlets.destroy');
    Route::delete('/outlets/temp-delete/{index}', [OutletController::class, 'hapusSementara'])->name('outlets.temp.delete');
    Route::post('/outlets/temp-reset', [OutletController::class, 'resetSementara'])->name('outlets.temp.reset');
    Route::get('/outlets/{id}/hapus', [OutletController::class, 'confirmDelete'])->name('outlets.confirmDelete');

   // crud admin
    Route::get('user/admin', [UserAdminController::class, 'index'])->name('user.admin');
    Route::post('user/admin', [UserAdminController::class, 'store'])->name('user.admin.store');
    Route::post('user/admin/simpan', [UserAdminController::class, 'simpan'])->name('user.admin.simpan');
    Route::get('user/admin/edit/{id}', [UserAdminController::class, 'edit'])->name('user.admin.edit');
    Route::put('user/admin/edit/{id}', [UserAdminController::class, 'update'])->name('user.admin.update');
    Route::get('user/admin/hapus/{id}', [UserAdminController::class, 'confirmDelete'])->name('user.admin.confirmDelete');
    Route::delete('user/admin/hapus/{id}', [UserAdminController::class, 'destroy'])->name('user.admin.destroy');
    Route::delete('user/admin/temp/delete/{index}', [UserAdminController::class, 'hapusSementara'])->name('user.admin.deleteTemp');
    Route::post('user/admin/temp/reset', [UserAdminController::class, 'resetSementara'])->name('user.admin.temp.reset');
    Route::get('user/admin/laporan', [UserAdminController::class, 'laporanadmin'])->name('user.adminlaporan');
    Route::get('user/pengguna/laporan', [penggunaController::class, 'laporanpengguna'])->name('user.penggunalaporan');
    Route::get('user/petugas/laporan', [UserKaryawanController::class, 'laporanpetugas'])->name('user.petugaslaporan');
    Route::get('user/supervisor/laporan', [SupervisorController::class, 'laporansupervisor'])->name('user.supervisorlaporan');
    //setting
   
    Route::get('/setting/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/setting/edit', [SettingController::class, 'update'])->name('setting.update');
 
// petugas/karyawan
    Route::get('user/karyawan', [UserKaryawanController::class, 'index'])->name('user.karyawan');
    Route::post('user/karyawan', [UserKaryawanController::class, 'store'])->name('user.karyawan.store');
    Route::post('user/karyawan/simpan', [UserKaryawanController::class, 'simpan'])->name('user.karyawan.simpan');
    Route::get('user/karyawan/edit/{id}', [UserKaryawanController::class, 'edit'])->name('user.karyawan.edit');
    Route::put('user/karyawan/edit/{id}', [UserKaryawanController::class, 'update'])->name('user.karyawan.update');
    Route::get('user/karyawan/hapus/{id}', [UserKaryawanController::class, 'confirmDelete'])->name('user.karyawan.confirmDelete');
    Route::delete('user/karyawan/hapus/{id}', [UserKaryawanController::class, 'destroy'])->name('user.karyawan.destroy');
    Route::delete('user/karyawan/temp/delete/{index}', [UserKaryawanController::class, 'hapusSementara'])->name('temp.delete');
    Route::post('user/karyawan/temp/reset', [UserKaryawanController::class, 'resetSementara'])->name('user.karyawan.temp.reset');

//supervisor
    Route::get('user.supervisor', [SupervisorController::class, 'index'])->name('user.supervisor');
    Route::delete('/user/supervisor/temp/delete/{index}', [SupervisorController::class, 'deleteTemp'])->name('user.supervisor.temp-delete');
    Route::prefix('user/supervisor')->name('user.supervisor.')->group(function () {
    Route::post('/', [SupervisorController::class, 'store'])->name('store');
    Route::post('/simpan', [SupervisorController::class, 'simpan'])->name('simpan');
    Route::get('/{id}/edit', [SupervisorController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SupervisorController::class, 'update'])->name('update');
    Route::get('/{id}/hapus', [SupervisorController::class, 'confirmDelete'])->name('confirmDelete');
    Route::delete('/{id}', [SupervisorController::class, 'destroy'])->name('destroy');  
    });


// pengguna
    Route::get('user.pengguna', [PenggunaController::class, 'index'])->name('user.pengguna');
    Route::delete('/user/pengguna/temp/delete/{index}', [PenggunaController::class, 'deleteTemp'])->name('user.pengguna.temp-delete');
    Route::prefix('user/pengguna')->name('user.pengguna.')->group(function () {
    Route::post('/', [PenggunaController::class, 'store'])->name('store');
    Route::post('/simpan', [PenggunaController::class, 'simpan'])->name('simpan');
    Route::get('/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
    Route::get('/{id}/hapus', [PenggunaController::class, 'confirmDelete'])->name('confirmDelete');
    Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
    });
// paket laundry

    Route::get('/paket-laundry', [PaketLaundryController::class, 'index'])->name('paket_laundry.index');
    Route::post('/paket-laundry', [PaketLaundryController::class, 'store'])->name('paket_laundry.store');
    Route::post('/paket-laundry/simpan', [PaketLaundryController::class, 'simpan'])->name('paket_laundry.simpan');
    Route::get('/paket-laundry/edit/{id}', [PaketLaundryController::class, 'edit'])->name('paket_laundry.edit');
    Route::put('/paket-laundry/update/{id}', [PaketLaundryController::class, 'update'])->name('paket_laundry.update');
    Route::delete('/paket-laundry/delete/{id}', [PaketLaundryController::class, 'destroy'])->name('paket_laundry.destroy');
    Route::delete('/paket-laundry/temp-delete/{index}', [PaketLaundryController::class, 'hapusSementara'])->name('paket_laundry.temp.delete');
    Route::post('/paket-laundry/temp-reset', [PaketLaundryController::class, 'resetSementara'])->name('paket_laundry.temp.reset');
    Route::get('/paket-laundry/{id}/hapus', [PaketLaundryController::class, 'confirmDelete'])->name('paket_laundry.confirmDelete');

// member

    Route::get('/member/bayar', [MemberController::class, 'bayarPendaftaran'])->name('member.bayar');
    Route::get('/member/sukses', [MemberController::class, 'sukses'])->name('member.sukses');
    Route::get('dasboard',[adminController::class,'dasboard'])->name('dasboard');
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::resource('members', MemberController::class);
//register
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// topup
Route::post('/topup/proses', [TopupController::class, 'proses'])->name('topup.proses');
Route::get('/topup/status/{order_id}', [TopupController::class, 'cekStatus'])->name('topup.status');
//logout

Route::middleware(['auth'])->group(function () {
    Route::get('/topup', fn() => view('topup.index'))->name('topup.index');
    Route::post('/topup/proses', [TopupController::class, 'proses'])->name('topup.proses');
    Route::get('/topup/cek-status/{order_id}', [TopupController::class, 'cekStatus'])->name('topup.cekStatus');
    Route::get('/topup/histori', [TopupController::class, 'histori'])->name('topup.histori');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/item', [TransaksiController::class, 'tambahItem'])->name('transaksi.tambahItem');
    Route::delete('/transaksi/item/{key}', [TransaksiController::class, 'hapusItem'])->name('transaksi.hapusItem');
    Route::post('/transaksi/simpan', [TransaksiController::class, 'simpan'])->name('transaksi.simpan');
    Route::put('/transaksi/update-status/{id}', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::patch('/transaksi/{id}/ubah-status', [TransaksiController::class, 'ubahStatus'])->name('transaksi.ubahStatus');
});
Route::get('/promo-member', [PromoMemberController::class, 'index'])->name('promo.member');
Route::post('/promo-member/store', [PromoMemberController::class, 'store'])->name('promo.member.store');
Route::post('/promo-member/simpan', [PromoMemberController::class, 'simpan'])->name('promo.member.simpan');
Route::get('/promo-member/edit/{id}', [PromoMemberController::class, 'edit'])->name('promo.member.edit');
Route::put('/promo-member/update/{id}', [PromoMemberController::class, 'update'])->name('promo.member.update');
Route::delete('/promo-member/delete/{id}', [PromoMemberController::class, 'destroy'])->name('promo.member.destroy');
Route::delete('/promo-member/temp-delete/{index}', [PromoMemberController::class, 'deleteTemp'])->name('promo.member.deleteTemp');

    Route::get('logout',[adminController::class,'logout'])->name('logout');

});


