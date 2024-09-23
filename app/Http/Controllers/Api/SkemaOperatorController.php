<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Skema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SkemaOperatorController extends Controller
{
    public function index($tahun, $kegiatan)
    {

        // Mengambil data skema berdasarkan kategori dan tahun
        $skema = Skema::where('tahun', $tahun)
            ->where('kegiatan', $kegiatan)
            ->get(); // Menggunakan get() untuk mendapatkan koleksi data
        return new PostResource(true, 'List Data', $skema);
    }

    public function show($id)
    {
        //find post by ID
        $skema = Skema::find($id);

        if (!$skema) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404); // Return 404 error if berita not found
        }

        //return single post as a resource
        return new PostResource(true, 'Detail Data', $skema);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_skema' => 'required',
            'tahun'      => 'required',
            'kegiatan'   => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create
        $post = Skema::create([
            'kode_skema' => Str::random(10) . rand(10000, 99999), // 20 huruf acak + 5 angka
            'nama_skema' => $request->nama_skema,
            'tahun'      => $request->tahun,
            'kegiatan'   => $request->kegiatan,
        ]);

        //return response
        return new PostResource(true, 'Data Berhasil Ditambahkan!', $post);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_skema' => 'required',
            'tahun'      => 'required',
            'kegiatan'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find by ID
        $skema = Skema::find($id);

        if (!$skema) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $skema->update([
            //'kode_skema' => Str::random(10) . rand(10000, 99999), // 20 huruf acak + 5 angka
            'nama_skema' => $request->nama_skema,
            'tahun'      => $request->tahun,
            'kegiatan'   => $request->kegiatan,
        ]);


        //return response
        return new PostResource(true, 'Data Berhasil Diubah!', $skema);
    }

    public function destroy($id)
    {

        // Find by ID
        $skema = Skema::find($id);

        if (!$skema) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Delete
        $skema->delete();

        //return response
        return new PostResource(true, 'Data Berhasil Dihapus!', null);
    }
}
