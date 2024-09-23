<?php

namespace App\Http\Controllers\Api;

//import Model "Post"
use App\Models\Usulan;
use App\Models\Skema;
use App\Models\CatatanHarian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
use App\Models\CatatanKegiatan;
//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CatatanHarianController extends Controller
{
    public function CatatanHarian($tahun, $kegiatan)
    {
        $data = Skema::leftJoin('usulan', 'skema.id', '=', 'usulan.id_skema')
            ->select(
                'skema.kode_skema',
                'skema.nama_skema',
                DB::raw('COUNT(usulan.id) as jumlah_usulan')
            )
            ->where('skema.tahun', $tahun)
            ->where('skema.kegiatan', $kegiatan)
            ->groupBy(
                'skema.id',
                'skema.kode_skema',
                'skema.nama_skema'
            )
            ->get();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return new PostResource(true, 'List Data', $data);
    }

    public function CatatanHarianList($kode)
    {
        // Ambil semua data dari tabel usulan
        $usulan = Usulan::leftJoin('skema', 'usulan.id_skema', '=', 'skema.id')
            ->leftJoin('personil_dosen', 'usulan.id', '=', 'personil_dosen.id_usulan')
            ->select(
                'usulan.kode_usulan',
                'usulan.judul',
                'usulan.dana_disetujui',
                DB::raw("(SELECT nidn FROM personil_dosen WHERE usulan.id = personil_dosen.id_usulan AND nama_peran = 'Ketua-Pengusul' LIMIT 1) AS nomor_nidn"),
                DB::raw("(SELECT nama FROM personil_dosen WHERE usulan.id = personil_dosen.id_usulan AND nama_peran = 'Ketua-Pengusul' LIMIT 1) AS nama_ketua"),
                DB::raw("(SELECT COUNT(id) FROM catatan_kegiatan WHERE usulan.id = catatan_kegiatan.id_usulan) AS jumlah_catatan"),
                DB::raw("(SELECT MAX(persentase_kegiatan) FROM catatan_kegiatan WHERE usulan.id = catatan_kegiatan.id_usulan) AS jumlah_persentase"),
            )
            ->where('skema.kode_skema', $kode)
            ->groupBy(
                'usulan.id',
                'usulan.kode_usulan',
                'usulan.judul',
                'usulan.dana_disetujui',
            )
            ->get();

        // Ambil semua data dari tabel skema
        $skema = Skema::where('kode_skema', $kode)->first();

        if (!$skema) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if (!$usulan) {
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

    public function CatatanHarianDetail($kodeskema, $kodeusulan)
    {
        // Ambil semua data dari tabel usulan
        $usulan = Usulan::select(
            'usulan.judul',
            'usulan.lama_kegiatan',
        )
            ->where('usulan.kode_usulan', $kodeusulan)
            ->first();

        // Ambil semua data dari tabel skema
        $skema = Skema::where('kode_skema', $kodeskema)->first();

        $catatan = CatatanKegiatan::leftJoin('usulan', 'catatan_kegiatan.id_usulan', '=', 'usulan.id')
            ->select(
                'catatan_kegiatan.tgl_kegiatan',
                'catatan_kegiatan.uraian_kegiatan',
                'catatan_kegiatan.persentase_kegiatan'
            )
            ->where('usulan.kode_usulan', $kodeusulan)
            ->orderby('catatan_kegiatan.tgl_kegiatan', 'DESC')
            ->get();

        if (!$skema) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if (!$usulan) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if (!$catatan) {
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
                'skema' => $skema,
                'catatan' => $catatan
            ]
        ], 200);
    }
}
