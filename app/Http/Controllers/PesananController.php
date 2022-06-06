<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PesananController extends Controller
{
    public function tambah_transaksi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'nama' => ['required'],
            'telepon' => ['required'],
            'alamat' => ['required'],
            'kurir' => ['required'],
            'harga_total' => ['required'],
            'harga' => ['required'],
            'ongkir' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, Response::HTTP_OK);
        }
        $data = $request->all();
        date_default_timezone_set('Asia/Jakarta');
        $hari = date('m-Y h:i:s', time());
        // Given string

        $nomorpesanan = $this->RemoveSpecialChar($hari) . $this->RemoveSpecialChar(strtolower($request->nama)) . $request->id_user;
        $data['nomorpesanan'] = $nomorpesanan;
        //tambah pesanan
        $pesanan = Pesanan::create($data);
        //update keranjang
        Keranjang::where('id_user', $request->id_user)
            ->where('is_status', 0)
            ->update([
                'is_status' => 1,
                'nomorpesanan' => $nomorpesanan
            ]);

        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $pesanan
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    function RemoveSpecialChar($str)
    {

        // Using str_replace() function 
        // to replace the word 
        $res = str_replace(array(
            '\'', '"',
            ',', ';', '<', '>', '-', ' ', ':'
        ), '', $str);

        // Returning the result 
        return $res;
    }
}
