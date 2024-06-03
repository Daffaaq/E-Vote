<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = [
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
}
