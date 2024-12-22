<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $perPage = 12;
    protected $cacheDuration = 3600; // 1 hour

    public function index(Request $request)
    {
        try {
            $request->validate([
                'page' => 'nullable|integer|min:1',
                'per_page' => ['nullable', 'integer', Rule::in([12, 24, 36])],
                'category' => 'nullable|exists:categories,id'
            ]);

            $perPage = $request->input('per_page', $this->perPage);
            $page = $request->input('page', 1);
            $categoryId = $request->input('category');
            
            // Generate cache key based on request parameters
            $cacheKey = "products.{$categoryId}.{$page}.{$perPage}";
            
            // Try to get from cache first
            $viewData = Cache::remember($cacheKey, $this->cacheDuration, function () use ($categoryId, $perPage) {
                $query = Product::with('category') // Only eager load category
                    ->where('is_active', true);
                
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }
                
                $products = $query->orderBy('sort_order')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);

                $categories = Category::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();

                return compact('products', 'categories');
            });

            return view('products.index', $viewData);
        } catch (\Exception $e) {
            Log::error('Products page error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function show(Product $product)
    {
        try {
            if (!$product->is_active) {
                abort(404);
            }

            // Cache individual product pages
            $cacheKey = "product.{$product->id}";
            
            $viewData = Cache::remember($cacheKey, $this->cacheDuration, function () use ($product) {
                $product->load('category'); // Only eager load category
                
                $relatedProducts = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->where('is_active', true)
                    ->with('category')
                    ->limit(4)
                    ->get();

                return compact('product', 'relatedProducts');
            });

            return view('products.show', $viewData);
        } catch (\Exception $e) {
            Log::error('Product show error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $cacheKey = "category.{$category->id}.products.page." . request()->get('page', 1);
        
        $products = Cache::remember($cacheKey, $this->cacheDuration, function () use ($category) {
            return Product::where('category_id', $category->id)
                ->where('is_active', true)
                ->with('category')
                ->orderBy('sort_order')
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        });

        return view('products.category', compact('category', 'products'));
    }
}
