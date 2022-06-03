<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
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

        Keranjang::create($request->all());
        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
