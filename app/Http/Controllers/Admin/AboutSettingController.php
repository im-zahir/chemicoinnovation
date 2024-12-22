<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSettingController extends Controller
{
    public function edit()
    {
        $settings = AboutSetting::firstOrCreate([]);
        return view('admin.about.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'mission' => 'nullable|string',
                'vision' => 'nullable|string',
                'history_title' => 'nullable|string|max:255',
                'history_description' => 'nullable|string',
                'team_title' => 'nullable|string|max:255',
                'team_description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'values' => 'nullable|array',
                'values.*' => 'nullable|string|max:255',
            ]);

            $settings = AboutSetting::firstOrCreate([]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($settings->image) {
                    Storage::disk('public')->delete($settings->image);
                }

                // Store new image
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/about'), $filename);
                $validated['image'] = 'about/' . $filename;
            }

            $settings->update($validated);

            return redirect()
                ->route('admin.about.edit')
                ->with('success', 'About page settings updated successfully.');
        } catch (\Exception $e) {
            \Log::error('About settings update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }
}
