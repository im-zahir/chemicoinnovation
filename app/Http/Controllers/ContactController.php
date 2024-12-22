<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactSetting;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $cacheDuration = 3600; // 1 hour

    public function index()
    {
        try {
            // Cache contact page data
            $viewData = Cache::remember('contact.page', $this->cacheDuration, function () {
                return [
                    'contactInfo' => ContactSetting::getSettings(),
                    'metaTitle' => 'Contact Us - ' . config('app.name'),
                    'metaDescription' => 'Get in touch with us. We\'d love to hear from you!'
                ];
            });

            return view('contact.index', $viewData);
        } catch (\Exception $e) {
            Log::error('Contact page error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
            ]);

            // Store the contact message in the database
            $contact = Contact::create($validated);

            // Queue the emails for better performance
            Mail::to(config('mail.admin_address', 'nabin.md07@gmail.com'))
                ->queue(new ContactFormMail($contact));

            Mail::to($contact->email)
                ->queue(new ContactFormMail($contact, true));

            return back()->with('success', 'Thank you for your message. We will get back to you soon!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'Sorry, there was a problem sending your message. Please try again later.')
                        ->withInput();
        }
    }
}
