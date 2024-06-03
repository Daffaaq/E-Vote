<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingVote extends Model
{
    use HasFactory;
    protected $table = 'setting_vote';

    protected $fillable = [
        'set_vote',
    ];
}
