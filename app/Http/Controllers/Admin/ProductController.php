<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $data = $this->handleProductData($request);
            
            // Create the product
            $product = Product::create($data);

            // Clear the cache
            Cache::forget('featured_products');
            Cache::forget('home_categories');

            Log::info('Product created successfully', [
                'id' => $product->id,
                'name' => $product->name
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Product creation failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create product. ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            // Debug log the request data
            Log::info('Product update request data:', [
                'all_data' => $request->all(),
                'is_featured' => $request->input('is_featured'),
                'is_featured_boolean' => $request->boolean('is_featured'),
                'has_is_featured' => $request->has('is_featured'),
            ]);
            
            $data = $this->handleProductData($request);
            
            // Debug log the validated data
            Log::info('Product update validated data:', [
                'data' => $data
            ]);
            
            // Update the product
            $product->update($data);

            // Clear the cache
            Cache::forget('featured_products');
            Cache::forget('home_categories');

            Log::info('Product updated successfully', [
                'id' => $product->id,
                'name' => $product->name,
                'is_featured' => $product->is_featured
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Product update failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
                'validation_errors' => $request->session()->get('errors')
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update product. ' . $e->getMessage());
        }
    }

    protected function handleProductData(Request $request): array
    {
        // Log the raw request data
        Log::info('handleProductData raw request:', [
            'all' => $request->all(),
            'is_featured' => $request->input('is_featured'),
            'is_featured_boolean' => $request->boolean('is_featured')
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*.name' => 'required_with:specifications.*.value|string',
            'specifications.*.value' => 'required_with:specifications.*.name|string',
        ]);

        // Log the validated data
        Log::info('handleProductData validated data:', [
            'data' => $data
        ]);

        // Clean empty features
        if (isset($data['features'])) {
            $data['features'] = array_values(array_filter($data['features'], function($feature) {
                return !empty(trim($feature));
            }));
        }

        // Clean empty specifications
        if (isset($data['specifications'])) {
            $data['specifications'] = array_values(array_filter($data['specifications'], function($spec) {
                return !empty(trim($spec['name'] ?? '')) && !empty(trim($spec['value'] ?? ''));
            }));
        }

        // Convert boolean fields from string to boolean
        $data['is_featured'] = (bool)$data['is_featured'];
        $data['is_active'] = (bool)$data['is_active'];

        // Log the final data
        Log::info('handleProductData final data:', [
            'data' => $data
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        return $data;
    }

    protected function handleImageUpload($file)
    {
        $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        
        // Store in public disk
        $path = $file->storeAs('products', $filename, 'public');

        Log::info('Product image uploaded', [
            'filename' => $filename,
            'path' => $path
        ]);

        return $path;
    }

    public function destroy(Product $product)
    {
        try {
            // Delete the product image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            // Clear the cache
            Cache::forget('featured_products');
            Cache::forget('home_categories');

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Product deletion failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete product. ' . $e->getMessage());
        }
    }
}
