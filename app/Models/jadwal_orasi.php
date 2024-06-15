<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_orasi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_orasis';

    protected $fillable = [
        'periode_id',
        'tanggal_orasi_vote',
        'jam_orasi_mulai',
        'tempat_orasi',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
