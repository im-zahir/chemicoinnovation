<?php

namespace Database\Seeders;

use App\Models\AboutSetting;
use Illuminate\Database\Seeder;

class AboutSettingSeeder extends Seeder
{
    public function run(): void
    {
        AboutSetting::firstOrCreate([], [
            'title' => 'Leading Chemical Solutions Provider',
            'subtitle' => 'Innovation & Excellence in Chemical Manufacturing',
            'description' => 'With decades of experience in the chemical industry, we are committed to providing high-quality chemical solutions while maintaining the highest standards of safety and environmental responsibility.',
            'mission' => 'To provide innovative and sustainable chemical solutions that enhance our customers\' processes and products while maintaining the highest standards of safety and environmental responsibility.',
            'vision' => 'To be the leading and most trusted provider of chemical solutions in the region, known for our innovation, quality, and commitment to sustainability.',
            'history' => 'Founded with a vision to revolutionize the chemical industry, our company has grown from a small local supplier to a major regional player. Through continuous innovation and unwavering commitment to quality, we have established ourselves as a trusted partner for businesses across various industries.',
            'values' => [
                'Quality Excellence',
                'Innovation & Research',
                'Environmental Responsibility',
                'Customer Focus',
                'Safety First',
                'Continuous Improvement'
            ]
        ]);
    }
}
