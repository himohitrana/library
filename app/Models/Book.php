<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'description',
        'cover_url',
        'price_sale',
        'price_rent',
        'stock',
        'status',
    ];

    protected $casts = [
        'price_sale' => 'decimal:2',
        'price_rent' => 'decimal:2',
    ];

    /**
     * Get the category that owns the book
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the wishlist entries for the book
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the cart entries for the book
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the rentals for the book
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the sales for the book
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Scope a query to only include available books
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where('status', 'available')->where('stock', '>', 0);
    }

    /**
     * Scope a query to search books
     */
    public function scopeSearch(Builder $query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeByCategory(Builder $query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeByStatus(Builder $query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if book is available for rent/purchase
     */
    public function isAvailable()
    {
        return $this->status === 'available' && $this->stock > 0;
    }

    /**
     * Get full cover URL
     */
    public function getCoverUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        if (str_starts_with($value, 'http')) {
            return $value;
        }
        
        return asset('storage/' . $value);
    }
}
