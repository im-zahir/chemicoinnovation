<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CheckProductImages extends Command
{
    protected $signature = 'products:check-images';
    protected $description = 'Check product images in the database and storage';

    public function handle()
    {
        $products = Product::all();
        
        $this->info("Checking product images...\n");
        
        foreach ($products as $product) {
            $this->info("Product: {$product->name}");
            $this->info("Image path: {$product->image}");
            $this->info("File exists: " . (Storage::disk('public')->exists('products/' . $product->image) ? 'Yes' : 'No'));
            $this->info("Full path: " . Storage::disk('public')->path('products/' . $product->image));
            $this->info("----------------------------------------\n");
        }
    }
}
