<?php

use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('', [OrderController::class, 'index'])->name('dashboard2');
Route::get('/order', [OrderController::class, 'directorder'])->name('directorder');
Route::get('/order/{id}',[OrderController::class, 'order'])->name('order');
Route::get('/history/{id}',[OrderController::class, 'history'])->name('history');
Route::get('/history',[OrderController::class, 'riwayat'])->name('historys');
Route::get('/invoice/{id}',[OrderController::class, 'invoice'])->name('invoice');
Route::put('/proof/{id}',[OrderController::class, 'proof'])->name('proof');

Route::post('/send-order',[OrderController::class, 'send'])->name('order.send');
Route::get('/get-price/{id}', [OrderController::class, 'getPrice'])->name('get-price');
Route::post('/cari-transaksi',[OrderController::class, 'cari'])->name('cari');

Route::get('/cari-data/{nomerhp}',[OrderController::class, 'cariData'])->name('cariData');
Route::get('/findInvoice/{id}',[OrderController::class, 'findInvoice'])->name('findInvoice');

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'] , function(){

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/create',[UserController::class, 'create'])->name('user.create');
    Route::post('/store',[UserController::class, 'store'])->name('user.store');
    Route::get('/edit/{id}',[UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}',[UserController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}',[UserController::class, 'delete'])->name('user.delete');

    Route::get('/paket',[PaketController::class, 'paket'])->name('paket');
    Route::get('/create-paket',[PaketController::class, 'create'])->name('paket.create');
    Route::post('/store-paket',[PaketController::class, 'store'])->name('paket.store');
    Route::get('/edit-paket/{id}',[PaketController::class, 'edit'])->name('paket.edit');
    Route::put('/update-paket/{id}',[PaketController::class, 'update'])->name('paket.update');
    Route::delete('/delete-paket/{id}',[PaketController::class, 'delete'])->name('paket.delete');

    Route::get('/produk',[ProdukController::class, 'produk'])->name('produk');
    Route::get('/create-produk',[ProdukController::class, 'create'])->name('produk.create');
    Route::post('/store-produk',[ProdukController::class, 'store'])->name('produk.store');
    Route::get('/edit-produk/{id}',[ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/update-produk/{id}',[ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/delete-produk/{id}',[ProdukController::class, 'delete'])->name('produk.delete');

    Route::get('/transaksi',[TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::get('/edit-transaksi/{id}',[TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/update-transaksi/{id}',[TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/delete-transaksi/{id}',[TransaksiController::class, 'delete'])->name('transaksi.delete');
    Route::get('/view-file/{filename}', [TransaksiController::class, 'viewFile'])->name('view-file');

    Route::get('/log',[LogController::class, 'log'])->name('log');

    Route::get('/get-products-by-paket/{id}', [ProdukController::class, 'getProductsByPaket']);
});

