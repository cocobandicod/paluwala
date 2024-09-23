<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatatanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'catatan_kegiatan'; // Specify the table name for the model

    protected $primaryKey = 'id'; // Specify the primary key column name

    protected $fillable = [
        'id_usulan',
        'tgl_kegiatan',
        'uraian_kegiatan',
        'persentase_kegiatan',
        'judul_berkas',
        'berkas',
        'tgl_upload',
    ];

    protected function fileBerkas(): Attribute
    {
        return Attribute::make(
            get: fn($fileBerkas) => url('/storage/catatankegiatan/' . $fileBerkas),
        );
    }
}
