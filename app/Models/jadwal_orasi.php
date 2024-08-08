<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class jadwal_orasi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_orasis';

    protected $fillable = [
        'uuid',
        'periode_id',
        'tanggal_orasi_vote',
        'jam_orasi_mulai',
        'tempat_orasi',
    ];

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
