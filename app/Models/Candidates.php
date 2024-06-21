<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'nama_ketua',
        'nama_wakil_ketua',
        'slug',
        'visi',
        'misi',
        'slogan',
        'foto',
        'periode_id',
    ];

    /**
     * Get the periode associated with the candidate.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
