<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GajiController;
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
Route::post('/hapus_produk', [ProdukController::class, 'hapus_produk']);
Route::post('/generate_qrcode', [ProdukController::class, 'generate_qrcode']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/detail_produk/{id?}', [ProdukController::class, 'detail_produk']);
Route::get('/search_produk/{id?}', [ProdukController::class, 'search_produk']);

//Keranjang
Route::post('/tambah_keranjang', [KeranjangController::class, 'tambah_keranjang']);
Route::post('/kurang_keranjang', [KeranjangController::class, 'kurang_keranjang']);
Route::post('/hapus_keranjang', [KeranjangController::class, 'hapus_keranjang']);
Route::get('/total_belanja/{id_user?}', [KeranjangController::class, 'total_belanja']);
Route::get('/get_keranjang/{id_user?}', [KeranjangController::class, 'get_keranjang']);
Route::get('/get_keranjang_pesanan/{nomorpesanan?}', [KeranjangController::class, 'get_keranjang_pesanan']);

//Pesanan
Route::post('/tambah_transaksi', [PesananController::class, 'tambah_transaksi']);
Route::post('/pesanan_selesai', [PesananController::class, 'pesanan_selesai']);
Route::post('/cetak_nota', [PesananController::class, 'cetak_nota']);
Route::get('/get_pesanan_id', [PesananController::class, 'get_pesanan_id']);
Route::get('/get_pesanan_owner', [PesananController::class, 'get_pesanan_owner']);

//Gaji
Route::post('/set_gaji', [GajiController::class, 'set_gaji']);
Route::post('/bayar_gaji', [GajiController::class, 'bayar_gaji']);
Route::get('/get_gaji', [GajiController::class, 'get_gaji']);
Route::get('/gaji_admin/{id_user?}', [GajiController::class, 'gaji_admin']);
Route::get('/riwayat_gaji_admin/{id_user?}', [GajiController::class, 'riwayat_gaji_admin']);
