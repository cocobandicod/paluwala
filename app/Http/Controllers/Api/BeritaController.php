<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Berita;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

//import Facade "Str"
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        //get all posts with user relationship loaded
        //$posts = Berita::with('user')->latest()->paginate(3);
        $berita = Berita::with('user')->orderBy('tgl_berita', 'desc')->paginate(3);

        //return collection of posts as a resource
        //return response()->json($berita);
        return new PostResource(true, 'List Data Berita', $berita);
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
            'id_user'        => 'required',
            'judul_berita'   => 'required',
            'judul_seo'    => Str::slug($request->judul_berita),
            'tgl_berita'     => 'required',
            'isi_berita'     => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/berita', $image->hashName());

        //create berita
        $berita = Berita::create([
            'id_user'      => $request->id_user,
            'judul_berita' => $request->judul_berita,
            'judul_seo'    => Str::slug($request->judul_berita),
            'tgl_berita'   => $request->tgl_berita,
            'isi_berita'   => $request->isi_berita,
            'image'        => $image->hashName(),
        ]);

        //return response
        return new PostResource(true, 'Data Berita Berhasil Ditambahkan!', $berita);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */

    /*
    public function show($id)
    {
        //find post by ID
        $post = Berita::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }
    */

    public function show($slug)
    {
        // Find post by slug
        $berita = Berita::with('user')->where('judul_seo', $slug)->firstOrFail();
        // Return single post as a resource
        return new PostResource(true, 'Detail Data Berita!', $berita);
    }

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
            'judul_berita'   => 'required',
            'tgl_berita'     => 'required',
            'isi_berita'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $berita = Berita::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/berita', $image->hashName());

            //delete old image
            Storage::delete('public/berita/' . basename($berita->image));

            //update post with new image
            $berita->update([
                'judul_berita' => $request->judul_berita,
                'judul_seo'    => Str::slug($request->judul_berita),
                'tgl_berita'   => $request->tgl_berita,
                'isi_berita'   => $request->isi_berita,
                'image'        => $image->hashName(),
            ]);
        } else {
            //update post without image
            $berita->update([
                'judul_berita' => $request->judul_berita,
                'judul_seo'    => Str::slug($request->judul_berita),
                'tgl_berita'   => $request->tgl_berita,
                'isi_berita'   => $request->isi_berita,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Berita Berhasil Diubah!', $berita);
    }

    public function destroy($id)
    {

        //find post by ID
        $berita = Berita::find($id);

        //delete image
        Storage::delete('public/berita/' . basename($berita->image));

        //delete post
        $berita->delete();

        //return response
        return new PostResource(true, 'Data Berita Berhasil Dihapus!', null);
    }
}
