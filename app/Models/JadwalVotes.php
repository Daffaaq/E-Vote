<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalVotes extends Model
{
    use HasFactory;
    protected $table = 'jadwal_votes';

    protected $fillable = [
        'periode_id',
        'tanggal_result_vote',
        'tanggal_awal_vote',
        'tanggal_akhir_vote',
        'tanggal_orasi_vote',
        'jam_orasi_mulai',
        'jam_orasi_selesai',
        'tempat_orasi',
    ];

    /**
     * Get the periode associated with the jadwal vote.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
