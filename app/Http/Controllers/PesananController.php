<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;
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
            'ongkir' => ['required'],
            'modal' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, 200);
        }
        //update keranjang
        $cekkerajang = Keranjang::where('id_user', $request->id_user)
            ->where('is_status', 0)->get();

        $data_keranjang = [];
        foreach ($cekkerajang as $data) {
            $data_keranjang = $data->jumlah;
            //cek produk
            $cek_produk  = Produk::where('id', $data->id_produk)->first();
            //update stok 
            $update_stok = Produk::where('id', $data->id_produk)->update([
                'stok' => (int)$cek_produk->stok - (int)$data->jumlah
            ]);
        }


        $data = $request->all();
        date_default_timezone_set('Asia/Jakarta');
        $hari = date('m-Y h:i:s', time());
        // Given string

        $nomorpesanan =  $request->id_user . time();

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

        //kurang stok

        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $pesanan
        ];

        return response()->json($response, 200);
    }

    public function pesanan_selesai(Request $request)
    {
        $update = Pesanan::where('id', $request->id)->update([
            'is_status' => 1
        ]);

        //update keranjang
        Keranjang::where('id_user', $request->id_user)
            ->where('nomorpesanan', $request->nomorpesanan)
            ->update([
                'is_proses' => 1
            ]);
        $response = [
            'message' => 'berhasil update',
            'status' => 1
        ];

        return response()->json($response, 200);
    }

    public function pesanan_dibatalkan(Request $request)
    {
        $nomorpesanan = $request->nomorpesanan;
        $id = $request->id;
        //update keranjang
        $cekkerajang = Keranjang::where('nomorpesanan', $nomorpesanan)
            ->get();

        $data_keranjang = [];
        foreach ($cekkerajang as $data) {
            $data_keranjang = $data->jumlah;
            //cek produk
            $cek_produk  = Produk::where('id', $data->id_produk)->first();
            //update stok 
            $update_stok = Produk::where('id', $data->id_produk)->update([
                'stok' => (int)$cek_produk->stok + (int)$data->jumlah
            ]);
        }

        $update = Pesanan::where('id', $id)->update([
            'is_status' => 2
        ]);
        $response = [
            'message' => 'berhasil update',
            'status' => 1
        ];

        return response()->json($response, 200);
    }

    public function get_pesanan_id(Request $request)
    {
        $data = Pesanan::where('id_user', $request->input('id_user'))
            ->orderBy('is_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $response = [
            'message' => 'berhasil diambil',
            'status' => 1,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function search_pesanan_id(Request $request)
    {
        $nama = $request->input('nama');
        $data = Pesanan::where('id_user', $request->input('id_user'))
            ->where('nama', 'like', "%$nama%")
            ->orderBy('is_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $response = [
            'message' => 'berhasil diambil',
            'status' => 1,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function get_pesanan_owner(Request $request)
    {
        $data = Pesanan::orderBy('is_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();


        $response = [
            'message' => 'berhasil diambil',
            'status' => 1,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function search_pesanan_owner(Request $request)
    {
        $nama = $request->input('nama');
        $data = Pesanan::where('nama', 'like', "%$nama%")
            ->orderBy('is_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();


        $response = [
            'message' => 'berhasil diambil',
            'status' => 1,
            'data' => $data
        ];

        return response()->json($response, 200);
    }


    public function cetak_nota(Request $request)
    {
        $data = Pesanan::where('id', $request->id)
            ->with('user')
            ->first();


        $keranjang = Keranjang::where('nomorpesanan', $request->nomorpesanan)
            ->with('produk')
            ->get();


        $customPaper = array(0, 0, 226.00, 283.80);
        $pdf = Pdf::loadView(
            'nota.nota',
            [
                'nota' => $data,
                'keranjang' => $keranjang
            ]
        )->setPaper($customPaper, 'potrait');

        $nomorpesanan = $request->nomorpesanan;

        $content = $pdf->download()->getOriginalContent();
        Storage::put("public/csv/nota/nota-$nomorpesanan.pdf", $content);
        $response = [
            'message' => 'sudah seawater hari ini',
            'status' => 1,
            'data' => url('/') . "/storage/csv/nota/nota-$nomorpesanan.pdf"
        ];
        return response()->json($response, 200);
    }

    public function cetak_transaksi(Request $request)
    {
        $database = Firebase::database();
        $data = $database->getReference('Transaksi')->getChild($request->id_transaksi)->getSnapshot()->getValue();
        $keranjang = $database->getReference('CartOrder')->getChild($request->id_transaksi)->getSnapshot()->getValue();
        $users = $database->getReference('users')->getChild($data['uid'])->getSnapshot()->getValue();
        $customPaper = array(0, 0, 226.00, 283.80);
        $timestamp = $data['timestamp'];
        $datetimeFormat = 'Y-m-d';
        $date = new \DateTime();
        $tanggal =  $date->format($datetimeFormat);
        $pdf = Pdf::loadView(
            'nota.notatransaksi',
            [
                'nota' => $data,
                'keranjang' => $keranjang,
                'users' => $users,
                'tanggal' => $tanggal
            ]
        )->setPaper($customPaper, 'potrait');

        $id_transaksi = $request->id_transaksi;

        $content = $pdf->download()->getOriginalContent();
        Storage::put("public/csv/nota/nota-$id_transaksi.pdf", $content);
        $response = [
            'message' => 'sudah seawater hari ini',
            'status' => 1,
            'data' => url('/') . "/storage/csv/nota/nota-$id_transaksi.pdf"
        ];
        return response()->json($response, 200);

      

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
