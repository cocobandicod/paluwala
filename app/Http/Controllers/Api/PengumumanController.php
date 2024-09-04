<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Pengumuman;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all Pengumuman
        $pengumuman = Pengumuman::with('user')->orderBy('tgl_pengumuman', 'desc')->paginate(3);

        //return collection of Pengumuman as a resource
        return new PostResource(true, 'List Data Pengumuman', $pengumuman);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_user'            => 'required',
            'judul_pengumuman'   => 'required',
            'tgl_pengumuman'     => 'required',
            'isi_pengumuman'     => 'required',
            'file_pengumuman'   => 'required|mimes:pdf|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload PDF file
        $file = $request->file('file_pengumuman');
        $file->storeAs('public/pengumuman', $file->hashName());

        //create berita
        $post = Pengumuman::create([
            'id_user'           => $request->id_user,
            'judul_pengumuman'  => $request->judul_pengumuman,
            'tgl_pengumuman'    => $request->tgl_pengumuman,
            'isi_pengumuman'    => $request->isi_pengumuman,
            'file_pengumuman'   => $file->hashName(),
        ]);

        //return response
        return new PostResource(true, 'Data Pengumuman Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */

    public function show($id)
    {
        //find post by ID
        $pengumuman = Pengumuman::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $pengumuman);
    }

    /*
    public function show($id)
    {
        // Find post by slug
        $pengumuman = Pengumuman::where('judul_seo', $slug)->firstOrFail();

        // Return single Pengumuman as a resource
        return new PostResource(true, 'Detail Data Pengumuman!', $pengumuman);
    }
    */

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'judul_pengumuman'   => 'required',
            'tgl_pengumuman'     => 'required',
            'isi_pengumuman'     => 'required',
            'file_pengumuman'    => 'nullable|mimes:pdf|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find Pengumuman by ID
        $pengumuman = Pengumuman::find($id);

        if (!$pengumuman) {
            return response()->json(['message' => 'Pengumuman not found'], 404);
        }

        // Check if file_pengumuman is not empty
        if ($request->hasFile('file_pengumuman')) {

            // Upload PDF file
            $file = $request->file('file_pengumuman');
            $file->storeAs('public/pengumuman', $file->hashName());

            // Delete old file
            Storage::delete('public/pengumuman/' . basename($pengumuman->file_pengumuman));

            // Update Pengumuman with new file
            $pengumuman->update([
                'judul_pengumuman'  => $request->judul_pengumuman,
                'tgl_pengumuman'    => $request->tgl_pengumuman,
                'isi_pengumuman'    => $request->isi_pengumuman,
                'file_pengumuman'   => $file->hashName(),
            ]);
        } else {
            // Update Pengumuman without file
            $pengumuman->update([
                'judul_pengumuman'  => $request->judul_pengumuman,
                'tgl_pengumuman'    => $request->tgl_pengumuman,
                'isi_pengumuman'    => $request->isi_pengumuman,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Berita Berhasil Diubah!', $pengumuman);
    }

    public function destroy($id)
    {

        // Find Pengumuman by ID
        $pengumuman = Pengumuman::find($id);

        if (!$pengumuman) {
            return response()->json(['message' => 'Pengumuman not found'], 404);
        }

        // Delete PDF file
        Storage::delete('public/pengumuman/' . basename($pengumuman->file_pengumuman));

        // Delete Pengumuman
        $pengumuman->delete();

        //return response
        return new PostResource(true, 'Data Pengumuman Berhasil Dihapus!', null);
    }
}
