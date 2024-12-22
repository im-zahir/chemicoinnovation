<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Chemico',
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'company_tagline',
                'value' => 'Leading Chemical Solutions Provider',
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'company_founded',
                'value' => '1990',
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'about_mission',
                'value' => 'To provide innovative and sustainable chemical solutions that enhance industrial processes while maintaining the highest standards of safety and environmental responsibility.',
                'group' => 'about',
                'type' => 'textarea'
            ],
            [
                'key' => 'about_vision',
                'value' => 'To be the global leader in eco-friendly chemical solutions, driving innovation and sustainability in the chemical industry.',
                'group' => 'about',
                'type' => 'textarea'
            ],
            [
                'key' => 'about_history',
                'value' => 'Founded in 1990, Chemico has grown from a small local supplier to a leading chemical solutions provider. Our journey has been marked by continuous innovation, strategic expansion, and an unwavering commitment to quality and sustainability.',
                'group' => 'about',
                'type' => 'textarea'
            ],
            [
                'key' => 'about_values',
                'value' => json_encode([
                    [
                        'title' => 'Innovation',
                        'description' => 'Continuously pushing boundaries to develop new and better solutions.'
                    ],
                    [
                        'title' => 'Quality',
                        'description' => 'Maintaining the highest standards in all our products and services.'
                    ],
                    [
                        'title' => 'Sustainability',
                        'description' => 'Committed to environmentally responsible practices and solutions.'
                    ],
                    [
                        'title' => 'Safety',
                        'description' => 'Ensuring the wellbeing of our employees, customers, and environment.'
                    ],
                    [
                        'title' => 'Integrity',
                        'description' => 'Operating with honesty, transparency, and ethical business practices.'
                    ],
                    [
                        'title' => 'Customer Focus',
                        'description' => 'Dedicated to understanding and meeting our customers\' needs.'
                    ]
                ]),
                'group' => 'about',
                'type' => 'json'
            ],
            [
                'key' => 'hero_title',
                'value' => 'Welcome to Chemico',
                'group' => 'hero',
                'type' => 'text'
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Leading chemical innovation company',
                'group' => 'hero',
                'type' => 'text'
            ],
            [
                'key' => 'hero_cta_primary_text',
                'value' => 'Our Products',
                'group' => 'hero',
                'type' => 'text'
            ],
            [
                'key' => 'hero_cta_secondary_text',
                'value' => 'Contact Us',
                'group' => 'hero',
                'type' => 'text'
            ],
            [
                'key' => 'footer_about',
                'value' => 'Pioneering chemical innovations for a sustainable future. Leading the industry with cutting-edge solutions and unwavering commitment to quality.',
                'group' => 'footer',
                'type' => 'textarea'
            ],
            [
                'key' => 'footer_links',
                'value' => json_encode([
                    [
                        'title' => 'Products',
                        'url' => '/products'
                    ],
                    [
                        'title' => 'About Us',
                        'url' => '/about'
                    ],
                    [
                        'title' => 'Contact',
                        'url' => '/contact'
                    ]
                ]),
                'group' => 'footer',
                'type' => 'json'
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/chemico',
                'group' => 'social',
                'type' => 'url'
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/chemico',
                'group' => 'social',
                'type' => 'url'
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/company/chemico',
                'group' => 'social',
                'type' => 'url'
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/chemico',
                'group' => 'social',
                'type' => 'url'
            ],
            [
                'key' => 'about_title',
                'value' => 'About Chemico',
                'group' => 'about',
                'type' => 'text'
            ],
            [
                'key' => 'about_subtitle',
                'value' => 'Leading Chemical Solutions Provider',
                'group' => 'about',
                'type' => 'text'
            ],
            [
                'key' => 'about_description',
                'value' => 'With over three decades of experience, Chemico has established itself as a leading provider of innovative chemical solutions. Our commitment to quality, safety, and sustainability has made us a trusted partner for industries worldwide.',
                'group' => 'about',
                'type' => 'textarea'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
