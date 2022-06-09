<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            return response()->json($response, 200);
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

        return response()->json($response, 200);
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
            return response()->json($response, 200);
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

        return response()->json($response, 200);
    }

    public function detail_produk(Request $request)
    {
        $data = Produk::where('id', $request->input('id'))->first();
        if ($data != null) {
            $response = [
                'message' => 'data sebagai berikut',
                'status' => 1,
                'data' => $data
            ];
        } else {
            $response = [
                'message' => 'data kosong',
                'status' => 0,
                'data' => $data
            ];
        }
        return response()->json($response, 200);
    }
    public function index()
    {
        $data = Produk::all();
        $response = [
            'message' => 'data sebagai berikut',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function hapus_produk(Request $request)
    {
        $hapus = Produk::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->oldImage);
        $response = [
            'message' => 'berhasil hapus',
            'status' => 1
        ];

        return response()->json($response, 200);
    }

    public function search_produk(Request $request)
    {
        $id = $request->input('id');
        $data = Produk::where('id', 'like', "%$id%")->get();
        $response = [
            'message' => 'data sebagai berikut',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function generate_qrcode(Request $request)
    {

        $qrcode = base64_encode(QrCode::format('png')->size(260)->errorCorrection('H')->generate($request->id));

        $pdf = Pdf::loadView(
            'qrcode.qrcode',
            [
                'id' => $request->id
            ],
            compact('qrcode')
        )->setPaper([0, 0, 150, 180], 'potrait');

        $content = $pdf->download()->getOriginalContent();
        Storage::put("public/csv/qrcode/qrcode-$request->id.pdf", $content);
        $response = [
            'message' => 'sudah seawater hari ini',
            'status' => 1,
            'data' => url('/') . "/storage/csv/qrcode/qrcode-$request->id.pdf"
        ];
        return response()->json($response, 200);
    }
}
