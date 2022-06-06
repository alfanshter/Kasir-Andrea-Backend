<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KeranjangController extends Controller
{
    public function tambah_keranjang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => ['required'],
            'harga' => ['required'],
            'jumlah' => ['required'],
            'id_user' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, Response::HTTP_OK);
        }

        $cekkeranjang = Keranjang::where('id_produk', $request->id_produk)
            ->where('id_user', $request->id_user)
            ->where('is_status', 0)
            ->first();
        if ($cekkeranjang == null) {
            Keranjang::create($request->all());
        } else {
            Keranjang::where('id_produk', $request->id_produk)
                ->where('id_user', $request->id_user)->update([
                    'jumlah' => $cekkeranjang->jumlah + (int)$request->jumlah
                ]);
        }
        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function get_keranjang(Request $request)
    {
        $data = Keranjang::where('id_user', $request->input('id_user'))
            ->where('is_status', 0)
            ->with('produk')
            ->with('user')
            ->get();
        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function get_keranjang_pesanan(Request $request)
    {
        $data = Keranjang::where('nomorpesanan', $request->input('nomorpesanan'))
            ->with('produk')
            ->with('user')
            ->get();
        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function kurang_keranjang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'jumlah' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, Response::HTTP_OK);
        }

        Keranjang::where('id', $request->id)
            ->update([
                'jumlah' => (int)$request->jumlah - 1
            ]);

        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function hapus_keranjang(Request $request)
    {
        $delete = Keranjang::where('id', $request->id)->delete();
        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function total_belanja(Request $request)
    {
        $total = Keranjang::where('id_user', $request->input('id_user'))->where('is_status', 0)->sum(DB::raw('harga * jumlah'));
        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'total_belanja' => (int)$total
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
