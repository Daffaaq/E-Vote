<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Periode extends Model
{
    use HasFactory;
    // Nama tabel di database
    protected $table = 'periode';

    // Properti yang dapat diisi
    protected $fillable = [
        'uuid',
        'periode_nama',
        'periode_kepala_sekolah',
        'periode_no_kepala_sekolah',
        'actif',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function votes()
    {
        return $this->hasMany(Votes::class, 'periode_id');
    }
}
