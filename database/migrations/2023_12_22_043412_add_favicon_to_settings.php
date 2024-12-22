<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up()
    {
        // Add favicon setting if it doesn't exist
        if (!Setting::where('key', 'site_favicon')->exists()) {
            Setting::create([
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'file',
                'group' => 'site',
            ]);
        }
    }

    public function down()
    {
        Setting::where('key', 'site_favicon')->delete();
    }
};
