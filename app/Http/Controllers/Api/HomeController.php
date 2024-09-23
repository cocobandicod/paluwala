<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\Sponsor;

use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

class HomeController extends Controller
{
    public function index()
    {

        //get all posts with user relationship loaded
        //$posts = Berita::with('user')->latest()->paginate(3);
        $sponsor = Sponsor::latest()->get();

        $berita = Berita::with('user')
            ->orderBy(
                'tgl_berita',
                'desc'
            )
            ->limit(3)
            ->get();

        $pengumuman = Pengumuman::with('user')
            ->orderBy(
                'tgl_pengumuman',
                'desc'
            )
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sukses',
            'data' => [
                'sponsor' => $sponsor,
                'berita' => $berita,
                'pengumuman' => $pengumuman
            ]
        ], 200);
    }
}
