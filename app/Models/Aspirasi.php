<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Aspirasi extends Model
{
    use HasFactory;
    protected $table = 'aspirasis';

    // Jika field yang dapat diisi secara massal
    protected $fillable = [
        'uuid',
        'nama',
        'nis',
        'kelas',
        'description_profiles',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
