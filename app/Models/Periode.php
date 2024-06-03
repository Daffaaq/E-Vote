<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    // Nama tabel di database
    protected $table = 'periode';

    // Properti yang dapat diisi
    protected $fillable = [
        'periode_nama',
        'periode_kepala_sekolah',
        'periode_no_kepala_sekolah',
        'actif',
    ];
}
