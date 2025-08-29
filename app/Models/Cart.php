<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'book_id',
        'mode',
        'rental_days',
        'quantity',
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book in the cart
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the total price for this cart item
     */
    public function getTotalPriceAttribute()
    {
        $price = $this->mode === 'rent' ? $this->book->price_rent : $this->book->price_sale;
        
        if ($this->mode === 'rent' && $this->rental_days) {
            $price = $price * $this->rental_days;
        }
        
        return $price * $this->quantity;
    }
}
