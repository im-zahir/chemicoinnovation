<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'mission',
        'vision',
        'history_title',
        'history_description',
        'team_title',
        'team_description',
        'image',
        'values',
    ];

    protected $casts = [
        'values' => 'array',
    ];

    public static function getSettings()
    {
        return self::firstOrCreate([]);
    }
}
