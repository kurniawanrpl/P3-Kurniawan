<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\userController;
use App\Http\Controllers\OutletController;


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
   
    Route::get('/', function () {
        return view('landing.landing'); // Halaman landing page
    })->name('landing');
   

});
Route::get('home', function () {
    if (Auth::user()->role == 'admin') {
        return redirect('admin/dasboard');
        }elseif (Auth::user()->role == 'supervisor') {
         return redirect('admin/dasboard');
         }elseif (Auth::user()->role == 'karyawan') {
            return redirect('admin/dasboard');
            }elseif (Auth::user()->role == 'owner') {
                return redirect('admin/dasboard');
                }
                
});

Route::middleware('auth')->group(function () {
    Route::get('admin/dasboard', function () {
        return view('admin/dasboard'); // Halaman setelah login
    })->name('dashboard');

   

 
    Route::get('/outlets', [OutletController::class, 'index'])->name('outlets.index');
    Route::post('/outlets/store-temp', [OutletController::class, 'storeTemp'])->name('outlets.storeTemp');
    Route::post('/outlets/save-temp', [OutletController::class, 'saveTemp'])->name('outlets.saveTemp');
    Route::post('/outlets/reset-temp', [OutletController::class, 'resetTemp'])->name('outlets.resetTemp');
    Route::get('/outlets/edit/{id}', [OutletController::class, 'edit'])->name('outlets.edit');
    Route::put('/outlets/update/{id}', [OutletController::class, 'update'])->name('outlets.update');
    Route::delete('/outlets/delete/{id}', [OutletController::class, 'destroy'])->name('outlets.destroy');
//logout
    Route::get('logout',[adminController::class,'logout'])->name('logout');

});


