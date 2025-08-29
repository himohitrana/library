<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'book_id',
        'status',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the enquiry that owns the sale
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    /**
     * Get the user that owns the sale
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is sold
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
