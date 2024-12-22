<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::firstOrCreate([
            'address' => '123 Chemical Street, Industrial Area, Dhaka-1000, Bangladesh',
            'phone' => '+880 1234-567890',
            'email' => 'info@chemico.com',
            'working_hours' => 'Mon-Fri: 9:00 AM - 6:00 PM',
            'facebook_url' => 'https://facebook.com/chemico',
            'twitter_url' => 'https://twitter.com/chemico',
            'linkedin_url' => 'https://linkedin.com/company/chemico',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.5380570145397!2d90.41975807599678!3d23.75169078458143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b85c366a6771%3A0x6c5e0b4c1a7d562c!2sBangladesh%20Chemical%20Industries%20Corporation!5e0!3m2!1sen!2sbd!4v1703072521123!5m2!1sen!2sbd',
        ]);
    }
}
