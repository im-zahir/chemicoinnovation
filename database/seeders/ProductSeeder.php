<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            // Industrial Chemicals
            [
                'name' => 'Industrial Grade Sulfuric Acid',
                'description' => 'High-purity sulfuric acid for industrial applications.',
                'specifications' => json_encode([
                    'Concentration' => '98%',
                    'Purity' => '99.9%',
                    'Density' => '1.84 g/cm³'
                ]),
                'features' => json_encode([
                    'High purity grade',
                    'Consistent quality',
                    'Bulk availability',
                    'Technical support available'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
                'category_name' => 'Industrial Chemicals'
            ],
            [
                'name' => 'Laboratory Grade Methanol',
                'description' => 'Pure methanol for laboratory use and analysis.',
                'specifications' => json_encode([
                    'Purity' => '99.9%',
                    'Density' => '0.792 g/cm³',
                    'Boiling Point' => '64.7°C'
                ]),
                'features' => json_encode([
                    'HPLC Grade',
                    'Low water content',
                    'Certificate of analysis provided'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
                'category_name' => 'Laboratory Reagents'
            ],
            [
                'name' => 'Custom Catalyst Solutions',
                'description' => 'Specialized catalysts for industrial processes.',
                'specifications' => json_encode([
                    'Customizable composition',
                    'Various particle sizes',
                    'Activity levels'
                ]),
                'features' => json_encode([
                    'Tailored to specific processes',
                    'High catalytic activity',
                    'Extended lifetime',
                    'Technical consultation available'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
                'category_name' => 'Specialty Chemicals'
            ],
            [
                'name' => 'Bio-Friendly Pesticide',
                'description' => 'Environmentally conscious pesticide solution.',
                'specifications' => json_encode([
                    'Active Ingredients' => 'Natural compounds',
                    'Biodegradability' => 'High',
                    'Residual Activity' => '14 days'
                ]),
                'features' => json_encode([
                    'Eco-friendly formula',
                    'Safe for beneficial insects',
                    'Rapid biodegradation',
                    'Broad spectrum activity'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
                'category_name' => 'Agricultural Chemicals'
            ],
            [
                'name' => 'Pharmaceutical Grade Excipients',
                'description' => 'High-quality excipients for pharmaceutical formulations.',
                'specifications' => json_encode([
                    'USP/EP Grade',
                    'Particle size distribution',
                    'Heavy metals < 10ppm'
                ]),
                'features' => json_encode([
                    'GMP certified',
                    'Full documentation',
                    'Stability tested',
                    'Consistent batch quality'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
                'category_name' => 'Pharmaceutical Ingredients'
            ]
        ];

        foreach ($products as $product) {
            $categoryName = $product['category_name'];
            unset($product['category_name']);
            
            $category = $categories->where('name', $categoryName)->first();
            
            if ($category) {
                $product['category_id'] = $category->id;
                $product['slug'] = Str::slug($product['name']);
                Product::create($product);
            }
        }
    }
}
