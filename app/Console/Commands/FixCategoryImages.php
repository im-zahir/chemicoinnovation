<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixCategoryImages extends Command
{
    protected $signature = 'fix:category-images';
    protected $description = 'Fix category image paths and move images to correct location';

    public function handle()
    {
        $categories = Category::whereNotNull('image')->get();
        $this->info('Found ' . $categories->count() . ' categories with images');

        foreach ($categories as $category) {
            $this->info("Processing category: {$category->name}");
            
            // Skip if image already in correct format
            if (str_starts_with($category->image, 'categories/')) {
                $this->info("Image already in correct format: {$category->image}");
                continue;
            }

            $oldPath = $category->image;
            $newPath = 'categories/' . basename($oldPath);

            // Check if old image exists in public storage
            if (Storage::disk('public')->exists($oldPath)) {
                // Move the file to categories directory
                Storage::disk('public')->move($oldPath, $newPath);
                $this->info("Moved image from {$oldPath} to {$newPath}");
            } else {
                $this->warn("Image file not found: {$oldPath}");
            }

            // Update the database record
            $category->image = $newPath;
            $category->save();
            $this->info("Updated database record for {$category->name}");
        }

        $this->info('Category image paths have been fixed');
    }
}
