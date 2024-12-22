<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'working_hours',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'map_url',
    ];

    public static function getSettings()
    {
        return self::first() ?? new self();
    }
}
