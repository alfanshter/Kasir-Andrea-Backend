<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProdukController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'harga' => ['required'],
            'stok' => ['required']
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
        $foto = $request->file('foto')->store('foto-produk', 'public');
        $data['foto'] = $foto;
        $response = [
            'message' => 'berhasil insert',
            'status' => $data
        ];
        Produk::create($data);
        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update_produk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'harga' => ['required'],
            'stok' => ['required']
        ]);


        if ($validator->fails()) {
            $response = [
                'message' => 'kesalahan',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, Response::HTTP_OK);
        }
        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ];


        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $data['foto'] = $request->file('foto')->store('foto-produk', 'public');
        }

        Produk::where('id', $request->id)->update($data);
        $response = [
            'message' => 'berhasil insert',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function index()
    {
        $data = Produk::all();
        $response = [
            'message' => 'data sebagai berikut',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
