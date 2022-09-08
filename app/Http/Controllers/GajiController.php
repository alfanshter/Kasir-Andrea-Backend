<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\GajiAdmin;
use App\Models\Keranjang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GajiController extends Controller
{
    public function set_gaji(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gaji' => 'required',
            'bonus' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        //cek data
        $cekdata = Gaji::first();
        if ($cekdata == null) {
            Gaji::create($request->all());
            $response = [
                'message' => 'tambah gaji berhasil',
                'status' => 1,
                'data' => $cekdata
            ];
        } else {
            $update = DB::table('gajis')->update($request->all());
            $response = [
                'message' => 'update gaji berhasil',
                'status' => 1,
                'data' => $cekdata
            ];
        }


        return response()->json($response, 200);
    }

    public function get_gaji()
    {
        $getgaji = Gaji::first();
        $response = [
            'message' => 'get gaji',
            'status' => 1,
            'data' => $getgaji
        ];



        return response()->json($response, 200);
    }

    public function gaji_admin(Request $request)
    {
        $getgaji = Gaji::first();
        if ($getgaji == null) {
            $gaji = 0;
            $bonus = 0;
        }

        $gaji = $getgaji->gaji;
        $bonus = $getgaji->bonus;
        $jumlah_penjualan = Keranjang::where('id_user', $request->input('id_user'))
            ->where('is_status', 1)
            ->where('is_proses', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('jumlah');

        $status_gaji = GajiAdmin::where('id_user', $request->input('id_user'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();

        if ($status_gaji == null) {
            $status_gaji = 0;
        } else {
            $status_gaji = 1;
        }

        $response = [
            'message' => 'get gaji',
            'status' => 1,
            'gaji' => $gaji,
            'bonus' => $bonus,
            'jumlah_penjualan' => $jumlah_penjualan,
            'status_gaji' => $status_gaji
        ];

        return response()->json($response, 200);
    }

    public function riwayat_gaji_admin(Request $request)
    {
        $gajiadmin = GajiAdmin::where('id_user', $request->input('id_user'))
            ->orderBy('created_at', 'desc')
            ->get();

        $response = [
            'message' => 'get gaji',
            'status' => 1,
            'data' => $gajiadmin
        ];



        return response()->json($response, 200);
    }

    public function bayar_gaji(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'gaji_pokok' => ['required'],
            'jumlah_penjualan' => ['required'],
            'bonus' => ['required'],
            'total_penghasilan' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        GajiAdmin::create($request->all());
        $response = [
            'message' => 'tambah gaji berhasil',
            'status' => 1,
            'data' => null
        ];



        return response()->json($response, 200);
    }
}
