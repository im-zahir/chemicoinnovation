<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_logo' => Setting::get('site_logo'),
            'company_name' => Setting::get('company_name'),
            'company_tagline' => Setting::get('company_tagline'),
        ];

        $hero = [
            'image' => Setting::get('hero_image'),
            'title' => Setting::get('hero_title'),
            'subtitle' => Setting::get('hero_subtitle'),
            'cta_primary_text' => Setting::get('hero_cta_primary_text'),
            'cta_secondary_text' => Setting::get('hero_cta_secondary_text'),
        ];

        $about = [
            'image' => Setting::get('about_image'),
            'title' => Setting::get('about_title'),
            'subtitle' => Setting::get('about_subtitle'),
            'description' => Setting::get('about_description'),
            'mission' => Setting::get('about_mission'),
            'vision' => Setting::get('about_vision'),
            'history' => Setting::get('about_history'),
        ];

        $social = [
            'facebook' => Setting::get('social_facebook'),
            'twitter' => Setting::get('social_twitter'),
            'linkedin' => Setting::get('social_linkedin'),
            'instagram' => Setting::get('social_instagram'),
        ];

        $footer = [
            'about' => Setting::get('footer_about'),
            'links' => Setting::get('footer_links', []),
        ];

        return view('admin.settings.index', compact('settings', 'hero', 'about', 'social', 'footer'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_tagline' => 'nullable|string|max:255',
                'site_logo' => 'nullable|image|max:1024',
                'hero_image' => 'nullable|image|max:2048',
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string',
                'hero_cta_primary_text' => 'nullable|string|max:255',
                'hero_cta_secondary_text' => 'nullable|string|max:255',
                'about_title' => 'nullable|string|max:255',
                'about_subtitle' => 'nullable|string|max:255',
                'about_description' => 'nullable|string',
                'about_mission' => 'nullable|string',
                'about_vision' => 'nullable|string',
                'about_history' => 'nullable|string',
                'social_facebook' => 'nullable|url|max:255',
                'social_twitter' => 'nullable|url|max:255',
                'social_linkedin' => 'nullable|url|max:255',
                'social_instagram' => 'nullable|url|max:255',
                'footer_about' => 'nullable|string',
                'footer_links' => 'nullable|array',
                'about_image' => 'nullable|image|max:2048',
            ]);

            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                $oldLogo = Setting::get('site_logo');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }

                $path = $request->file('site_logo')->store('logos', 'public');
                Setting::set('site_logo', $path);
            }

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                $oldImage = Setting::get('hero_image');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                $path = $request->file('hero_image')->store('hero', 'public');
                Setting::set('hero_image', $path);
            }

            // Handle about image upload
            if ($request->hasFile('about_image')) {
                $oldImage = Setting::get('about_image');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                $path = $request->file('about_image')->store('about', 'public');
                Setting::set('about_image', $path);
            }

            // Save all other settings
            foreach ($validated as $key => $value) {
                if (!in_array($key, ['site_logo', 'hero_image', 'about_image'])) {
                    // Special handling for footer_links
                    if ($key === 'footer_links' && is_array($value)) {
                        // Filter out empty links
                        $links = collect($value)->filter(function ($link) {
                            return !empty($link['title']) && !empty($link['url']);
                        })->values()->toArray();
                        
                        Setting::set($key, json_encode($links));
                    } else {
                        Setting::set($key, $value);
                    }
                }
            }

            // Clear all cache
            Cache::flush();

            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings. Please try again.');
        }
    }
}
