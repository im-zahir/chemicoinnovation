<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'specifications',
        'category_id',
        'image',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'features' => 'array',
        'specifications' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFeaturesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $value = array_values(array_filter($value, function($item) {
                return !empty(trim($item));
            }));
        }
        
        $this->attributes['features'] = is_array($value) ? json_encode($value) : null;
    }

    public function getSpecificationsAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    public function setSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            $value = array_values(array_filter($value, function($item) {
                return is_array($item) && 
                       isset($item['name'], $item['value']) && 
                       !empty(trim($item['name'])) && 
                       !empty(trim($item['value']));
            }));
        }
        
        $this->attributes['specifications'] = is_array($value) ? json_encode($value) : null;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = $product->generateUniqueSlug();
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') || empty($product->slug)) {
                $product->slug = $product->generateUniqueSlug();
            }
        });

        static::saving(function ($product) {
            if ($product->isDirty('image')) {
                $product->optimizeImage('image');
            }
            
            if ($product->isDirty('gallery')) {
                $product->optimizeGalleryImages();
            }
        });

        static::deleting(function ($product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        });
    }

    /**
     * Optimize the main product image
     */
    protected function optimizeImage($field)
    {
        if (!$this->$field) {
            return;
        }

        try {
            $path = storage_path('app/public/' . $this->$field);
            
            if (!file_exists($path)) {
                Log::error('Image file not found for optimization', [
                    'path' => $path,
                    'product_id' => $this->id
                ]);
                return;
            }

            $image = Image::make($path);

            // Resize if too large (max width: 1200px)
            if ($image->width() > 1200) {
                $image->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Optimize and save
            $image->save($path, 80);

            Log::info('Image optimized successfully', [
                'path' => $path,
                'product_id' => $this->id
            ]);
        } catch (\Exception $e) {
            Log::error('Image optimization failed', [
                'error' => $e->getMessage(),
                'product_id' => $this->id
            ]);
        }
    }

    /**
     * Optimize gallery images
     */
    protected function optimizeGalleryImages()
    {
        if (!is_array($this->gallery)) return;

        foreach ($this->gallery as $index => $path) {
            try {
                $image = Image::make(storage_path('app/public/' . $path));
                
                // Resize if too large while maintaining aspect ratio
                if ($image->width() > 800) {
                    $image->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                
                // Optimize quality
                $image->save(null, 75);
                
            } catch (\Exception $e) {
                Log::error("Gallery image optimization failed for index {$index}: " . $e->getMessage());
            }
        }
    }

    public function generateUniqueSlug()
    {
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 0;

        // Keep checking until we find a unique slug
        while (static::where('slug', $slug)->exists()) {
            $count++;
            $slug = "{$originalSlug}-{$count}";
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the product's main image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        // Check if the image exists
        if (!Storage::disk('public')->exists($this->image)) {
            Log::error('Product image not found', [
                'product_id' => $this->id,
                'image_path' => $this->image
            ]);
            return null;
        }
        
        // Use asset() helper as a fallback
        return asset('storage/' . $this->image);
    }

    /**
     * Get the product's gallery image URLs
     */
    public function getGalleryUrlsAttribute()
    {
        return collect($this->gallery)->map(function ($path) {
            try {
                // Check if the path is not empty and exists
                if (empty($path) || !Storage::disk('public')->exists($path)) {
                    Log::warning('Gallery image not found or path is empty', [
                        'product_id' => $this->id,
                        'image_path' => $path
                    ]);
                    return null;
                }
                
                // Use asset() as a fallback if url() fails
                return asset('storage/' . $path);
            } catch (\Exception $e) {
                Log::error('Error generating gallery image URL', [
                    'product_id' => $this->id,
                    'image_path' => $path,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        })->filter();
    }
}
