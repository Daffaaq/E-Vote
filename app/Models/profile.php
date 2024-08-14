<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';

    protected $fillable = [
        'uuid',
        'nickname_profiles',
        'name_profiles',
        'address_profiles',
        'phone_profiles',
        'email_profiles',
        'description_profiles',
        'logo_profiles',
        'twitter_url', //1
        'facebook_url', //2
        'instagram_url',//3
        'threads_url',//7
        'line_url', //5
        'linkedin_url', //4
        'tiktok_url', //6
        'youtube_url',//8
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
