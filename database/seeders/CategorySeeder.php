<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the categories directory exists
        $storagePath = storage_path('app/public/categories');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $categories = [
            [
                'name' => 'Industrial Chemicals',
                'description' => 'High-quality industrial chemicals for manufacturing and processing.',
                'is_active' => true,
                'sort_order' => 1,
                'image' => 'categories/industrial-chemicals.jpg'
            ],
            [
                'name' => 'Laboratory Reagents',
                'description' => 'Precise and pure reagents for laboratory research and analysis.',
                'is_active' => true,
                'sort_order' => 2,
                'image' => 'categories/laboratory-reagents.jpg'
            ],
            [
                'name' => 'Specialty Chemicals',
                'description' => 'Specialized chemical solutions for specific industrial applications.',
                'is_active' => true,
                'sort_order' => 3,
                'image' => 'categories/specialty-chemicals.jpg'
            ],
            [
                'name' => 'Agricultural Chemicals',
                'description' => 'Chemical products for agricultural and farming applications.',
                'is_active' => true,
                'sort_order' => 4,
                'image' => 'categories/agricultural-chemicals.jpg'
            ],
            [
                'name' => 'Pharmaceutical Ingredients',
                'description' => 'Chemical ingredients for pharmaceutical manufacturing.',
                'is_active' => true,
                'sort_order' => 5,
                'image' => 'categories/pharmaceutical-ingredients.jpg'
            ]
        ];

        // Create sample image files if they don't exist
        foreach ($categories as $category) {
            $imagePath = storage_path('app/public/' . $category['image']);
            if (!File::exists($imagePath)) {
                // Create a simple colored rectangle as a placeholder image
                $image = imagecreatetruecolor(800, 600);
                $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                imagefill($image, 0, 0, $color);
                
                // Add text to the image
                $white = imagecolorallocate($image, 255, 255, 255);
                $text = $category['name'];
                imagestring($image, 5, 250, 280, $text, $white);
                
                // Save the image
                imagejpeg($image, $imagePath, 90);
                imagedestroy($image);
            }
        }

        foreach ($categories as $category) {
            $category['slug'] = Str::slug($category['name']);
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
