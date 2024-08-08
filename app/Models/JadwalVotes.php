<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JadwalVotes extends Model
{
    use HasFactory;
    protected $table = 'jadwal_votes';

    protected $fillable = [
        'uuid',
        'periode_id',
        'tanggal_awal_vote',
        'tanggal_akhir_vote',
        'tempat_vote',
    ];

    /**
     * Get the periode associated with the jadwal vote.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
