<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Students extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = [
        'uuid',
        'nama',
        'nis',
        'kelas',
        'jenis_kelamin',
        'users_id',
        'status_students',
    ];

    /**
     * Get the user associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
