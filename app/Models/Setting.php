<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        try {
            $setting = Cache::remember('setting.' . $key, 3600, function() use ($key) {
                return self::where('key', $key)->first();
            });

            if (!$setting) {
                return $default;
            }

            $value = $setting->value;
            
            // Try to decode if it's a JSON string
            if (is_string($value) && in_array($setting->type, ['json', 'array'])) {
                try {
                    $decoded = json_decode($value, true);
                    return $decoded ?? $value;
                } catch (\Exception $e) {
                    Log::error('Error decoding JSON setting: ' . $key, [
                        'error' => $e->getMessage(),
                        'value' => $value
                    ]);
                    return $value;
                }
            }

            return $value;
        } catch (\Exception $e) {
            Log::error('Error getting setting value for key: ' . $key, [
                'error' => $e->getMessage()
            ]);
            return $default;
        }
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        try {
            // Convert arrays to JSON strings
            if (is_array($value)) {
                $value = json_encode($value);
            }

            $setting = self::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => self::determineGroup($key),
                    'type' => self::determineType($value)
                ]
            );

            // Clear the cache for this key
            Cache::forget('setting.' . $key);
            
            return $setting;
        } catch (\Exception $e) {
            Log::error('Error setting value for key: ' . $key, [
                'error' => $e->getMessage(),
                'value' => $value
            ]);
            throw $e;
        }
    }

    /**
     * Determine the group based on the key prefix
     */
    private static function determineGroup($key)
    {
        $prefixes = [
            'hero_' => 'hero',
            'about_' => 'about',
            'social_' => 'social',
            'footer_' => 'footer',
            'site_' => 'general',
            'company_' => 'general'
        ];

        foreach ($prefixes as $prefix => $group) {
            if (str_starts_with($key, $prefix)) {
                return $group;
            }
        }

        return 'general';
    }

    /**
     * Determine the type based on the value
     */
    private static function determineType($value)
    {
        if (is_array($value)) {
            return 'json';
        }

        if (is_string($value)) {
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return 'url';
            }

            if (strlen($value) > 255) {
                return 'textarea';
            }

            // Check if it's a JSON string
            json_decode($value);
            if (json_last_error() === JSON_ERROR_NONE) {
                return 'json';
            }
        }

        return 'text';
    }

    /**
     * Clear all settings cache
     *
     * @return void
     */
    public static function clearCache()
    {
        Cache::flush();
    }
}
