<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidates extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'uuid',
        'status',
        'no_urut_kandidat',
        'nama_ketua',
        'nama_wakil_ketua',
        'slug',
        'visi',
        'misi',
        'slogan',
        'foto',
        'foto_wakil',
        'periode_id',
    ];

    /**
     * Get the periode associated with the candidate.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function votes()
    {
        return $this->hasMany(Votes::class, 'candidate_id');
    }
}
