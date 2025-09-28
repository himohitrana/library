<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'type',
        'guest_info',
        'items',
        'status',
        'start_date',
        'end_date',
        'return_date',
        'notes',
        'admin_notes',
        'total_amount',
    ];

    protected $casts = [
        'guest_info' => 'array',
        'items' => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the enquiry
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rentals for this enquiry
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the sales for this enquiry
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Check if enquiry is from a guest
     */
    public function isGuest()
    {
        return $this->user_id === null;
    }

    /**
     * Get customer name (user or guest)
     */
    public function getCustomerNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        
        return $this->guest_info['name'] ?? 'Guest';
    }

    /**
     * Get customer email (user or guest)
     */
    public function getCustomerEmailAttribute()
    {
        if ($this->user) {
            return $this->user->email;
        }
        
        return $this->guest_info['email'] ?? null;
    }
}
