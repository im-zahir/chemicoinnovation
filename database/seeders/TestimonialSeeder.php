<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'John Smith',
                'client_position' => 'Production Manager',
                'client_company' => 'ABC Manufacturing Ltd.',
                'content' => 'The quality of industrial chemicals from Chemico Innovation has significantly improved our manufacturing process. Their technical support is outstanding.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'client_name' => 'Sarah Johnson',
                'client_position' => 'Research Director',
                'client_company' => 'XYZ Pharmaceuticals',
                'content' => 'We rely on Chemico Innovation for our laboratory reagents. Their products consistently meet our high standards for purity and reliability.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'client_name' => 'David Chen',
                'client_position' => 'Chief Agronomist',
                'client_company' => 'Green Fields Agriculture',
                'content' => 'The agricultural solutions provided by Chemico Innovation have helped us improve crop yields while maintaining environmental sustainability.',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'client_name' => 'Maria Garcia',
                'client_position' => 'Quality Control Manager',
                'client_company' => 'Pharma Solutions Inc.',
                'content' => 'Excellent quality pharmaceutical ingredients and responsive customer service. A reliable partner for our pharmaceutical manufacturing needs.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
