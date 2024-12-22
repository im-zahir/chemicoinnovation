<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = Category::whereNotNull('image')->get();
        
        foreach ($categories as $category) {
            if (!str_starts_with($category->image, 'categories/')) {
                $category->image = 'categories/' . basename($category->image);
                $category->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $categories = Category::whereNotNull('image')->get();
        
        foreach ($categories as $category) {
            if (str_starts_with($category->image, 'categories/')) {
                $category->image = basename($category->image);
                $category->save();
            }
        }
    }
};
