<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get featured products
            $featuredProducts = Cache::remember('featured_products', 3600, function () {
                return Product::where('is_featured', true)
                    ->where('is_active', true)
                    ->latest()
                    ->take(6)
                    ->get();
            });

            // Get categories
            $categories = Cache::remember('home_categories', 3600, function () {
                return Category::where('is_active', true)
                    ->latest()
                    ->take(6)
                    ->get();
            });

            // Get testimonials
            $testimonials = Cache::remember('home_testimonials', 3600, function () {
                return Testimonial::where('is_active', true)
                    ->latest()
                    ->take(3)
                    ->get();
            });

            // Log for debugging
            Log::info('Home Page Data:', [
                'featured_products' => $featuredProducts->count(),
                'categories' => $categories->count(),
                'testimonials' => $testimonials->count()
            ]);

            return view('home.index', compact('featuredProducts', 'categories', 'testimonials'));
        } catch (\Exception $e) {
            Log::error('Error on Home Page:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            // Return a error view or handle the exception as needed
            // For now, just return a simple error message
            return view('errors.error', ['message' => 'An error occurred while loading the home page.']);
        }
    }
}
