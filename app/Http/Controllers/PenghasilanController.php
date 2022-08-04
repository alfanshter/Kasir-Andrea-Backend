<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PenghasilanController extends Controller
{
    public function penghasilan_bulanan()
    {
        $pesanan = Pesanan::where('is_status', 1)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('harga');

        $modal = Pesanan::where('is_status', 1)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('modal');



        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'harga' => (int)$pesanan,
            'modal' => (int)$modal
        ];
        return response()->json($response, 200);
    }
}
