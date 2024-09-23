<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Usulan;
use App\Models\Skema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PerbaikanUsulanController extends Controller
{
    public function PerbaikanUsulan($tahun, $kegiatan)
    {
        $data = Usulan::leftJoin('skema', 'usulan.id_skema', '=', 'skema.id')
            ->leftJoin('personil_dosen', 'usulan.id', '=', 'personil_dosen.id_usulan')
            ->select(
                'usulan.kode_usulan',
                'usulan.judul',
                'usulan.lama_kegiatan',
                'usulan.bidang_fokus',
                'usulan.tgl_perbaikan',
                'usulan.dana_disetujui',
                'usulan.status_laporan',
                'skema.nama_skema',
                'skema.tahun',
                DB::raw("(SELECT nama FROM personil_dosen WHERE usulan.id = personil_dosen.id_usulan AND nama_peran = 'Ketua-Pengusul' LIMIT 1) AS nama_ketua"),
                DB::raw("SUM(CASE WHEN nama_peran != 'Ketua-Pengusul' THEN 1 ELSE 0 END) as jumlah_anggota")
            )
            ->where('skema.tahun', $tahun)
            ->where('skema.kegiatan', $kegiatan)
            ->groupBy(
                'usulan.kode_usulan',
                'usulan.id',
                'usulan.judul',
                'usulan.lama_kegiatan',
                'usulan.bidang_fokus',
                'usulan.tgl_perbaikan',
                'usulan.dana_disetujui',
                'usulan.status_laporan',
                'skema.nama_skema',
                'skema.tahun',
            )
            ->get();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return new PostResource(true, 'List Data', $data);
    }

    public function PerbaikanUsulanDetail()
    {
        // Ambil semua data dari tabel usulan
        $usulan = Usulan::all();

        // Ambil semua data dari tabel skema
        $skema = Skema::all();

        if (!$usulan) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if (!$skema) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Gabungkan hasil dan kembalikan dalam satu JSON response
        return response()->json([
            'success' => true,
            'message' => 'Sukses',
            'data' => [
                'usulan' => $usulan,
                'skema' => $skema
            ]
        ], 200);
    }
}
