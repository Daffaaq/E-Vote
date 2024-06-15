<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_result_vote extends Model
{
    use HasFactory;

    protected $table = 'jadwal_result_votes';
    protected $fillable = [
        'periode_id',
        'tanggal_result_vote',
        'jam_result_vote',
        'tempat_result_vote',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
