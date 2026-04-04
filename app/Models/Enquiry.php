<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'book_id' => 'array', // ✅ important
        'total_amount' => 'decimal:2',
    ];

    protected $appends = ['books']; // ✅ auto include

    /**
     * Get Books (handles JSON + string both)
     */


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y, h:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y, h:i A');
    }

    public function getReturnDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d M Y') : null;
    }


    public function getBooksAttribute()
    {
        $bookIds = $this->book_id;

        // handle string like "16,17"
        if (is_string($bookIds)) {
            $bookIds = explode(',', $bookIds);
        }

        if (!is_array($bookIds) || empty($bookIds)) {
            return collect();
        }

        return Book::whereIn('id', $bookIds)->get();
    }

    /**
     * User relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Rentals
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Sales
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function isGuest()
    {
        return $this->user_id === null;
    }

    public function getCustomerNameAttribute()
    {
        return $this->user->name ?? ($this->guest_info['name'] ?? 'Guest');
    }

    public function getCustomerEmailAttribute()
    {
        return $this->user->email ?? ($this->guest_info['email'] ?? null);
    }
}