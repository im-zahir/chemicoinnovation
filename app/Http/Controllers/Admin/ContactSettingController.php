<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function edit()
    {
        $settings = ContactSetting::getSettings();
        return view('admin.contact.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'working_hours' => 'required|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'map_url' => 'nullable|url|max:1000',
        ]);

        ContactSetting::updateOrCreate([], $validated);

        return redirect()->back()->with('success', 'Contact information updated successfully.');
    }
}
