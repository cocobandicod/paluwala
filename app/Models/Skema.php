<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema'; // Specify the table name for the model

    protected $primaryKey = 'id'; // Specify the primary key column name

    protected $fillable = [
        'kode_skema',
        'nama_skema',
        'tahun',
        'kegiatan',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
