<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'action',
        'url',
        'tanggal',
        'waktu',
        'data',
        'periode_id',
        'user_id',
    ];

    /**
     * Get the user associated with the log.
     */
    public function user()
    {
        // Defaultnya Laravel mencari kolom 'id' sebagai primary key di tabel users
        return $this->belongsTo(User::class, 'user_id', 'id');  // Kolom 'id' di tabel users
    }

    /**
     * Get the periode associated with the log.
     */
    public function periode()
    {
        // Pastikan foreign key dan primary key sesuai dengan yang ada di tabel periode
        return $this->belongsTo(Periode::class, 'periode_id', 'id'); // Kolom 'id' di tabel periodes
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
