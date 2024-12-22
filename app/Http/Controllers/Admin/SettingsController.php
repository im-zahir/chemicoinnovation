<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|file|mimes:ico,png|max:1024',
            'site_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();
            
            // Batch process all settings
            $settings = [];
            
            // Handle favicon upload
            if ($request->hasFile('site_favicon')) {
                $file = $request->file('site_favicon');
                $settings['site_favicon'] = $this->handleFileUpload($file, 'favicon', 'settings');
            }
            
            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $settings['site_logo'] = $this->handleFileUpload($file, 'logo', 'settings');
            }
            
            // Handle text settings
            $textSettings = ['site_title', 'contact_email', 'contact_phone', 'contact_address'];
            foreach ($textSettings as $setting) {
                if ($request->has($setting)) {
                    $settings[$setting] = $request->input($setting);
                }
            }
            
            // Batch update settings
            foreach ($settings as $key => $value) {
                Setting::set($key, $value);
            }
            
            // Clear settings cache
            Cache::tags(['settings'])->flush();
            
            DB::commit();
            return response()->json(['message' => 'Settings updated successfully']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Settings update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to update settings'], 500);
        }
    }
    
    private function handleFileUpload($file, $prefix, $directory)
    {
        // Delete old file if exists
        $oldFile = Setting::get($prefix);
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }
        
        // Generate optimized filename
        $filename = $prefix . '.' . $file->getClientOriginalExtension();
        
        // Store and optimize the file
        $path = $file->storeAs($directory, $filename, 'public');
        
        if (!$path) {
            throw new \Exception("Failed to store {$prefix} file");
        }
        
        return $path;
    }
}
