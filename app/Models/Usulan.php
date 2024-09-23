<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usulan extends Model
{
    use HasFactory;

    protected $table = 'usulan'; // Specify the table name for the model

    protected $primaryKey = 'id'; // Specify the primary key column name

    protected $fillable = [
        'id_skema',
        'judul',
        'lama_kegiatan',
        'bidang_fokus',
        'tgl_perbaikan',
        'dana_disetujui',
        'status_laporan',
    ];
}
