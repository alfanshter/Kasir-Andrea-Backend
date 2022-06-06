<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

//ADMIN
Route::post('/tambah_admin', [AuthController::class, 'tambah_admin']);
Route::get('/get_admin', [AuthController::class, 'get_admin']);
Route::get('/search_admin/{nama?}', [AuthController::class, 'search_admin']);

//Produk
Route::post('/produk', [ProdukController::class, 'store']);
Route::post('/update_produk', [ProdukController::class, 'update_produk']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/search_produk/{nama?}', [ProdukController::class, 'search_produk']);

//Keranjang
Route::post('/tambah_keranjang', [KeranjangController::class, 'tambah_keranjang']);
Route::post('/kurang_keranjang', [KeranjangController::class, 'kurang_keranjang']);
Route::post('/hapus_keranjang', [KeranjangController::class, 'hapus_keranjang']);
Route::get('/total_belanja/{id_user?}', [KeranjangController::class, 'total_belanja']);
Route::get('/get_keranjang/{id_user?}', [KeranjangController::class, 'get_keranjang']);
Route::get('/get_keranjang_pesanan/{nomorpesanan?}', [KeranjangController::class, 'get_keranjang_pesanan']);

//Pesanan
Route::post('/tambah_transaksi', [PesananController::class, 'tambah_transaksi']);
