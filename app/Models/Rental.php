<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'book_id',
        'start_date',
        'due_date',
        'returned_date',
        'status',
        'condition_notes',
        'amount',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'returned_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the enquiry that owns the rental
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    /**
     * Get the user that owns the rental
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is rented
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if rental is overdue
     */
    public function isOverdue()
    {
        return $this->status === 'active' && Carbon::now()->isAfter($this->due_date);
    }

    /**
     * Get days remaining until due date
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->status !== 'active') {
            return null;
        }
        
        return Carbon::now()->diffInDays($this->due_date, false);
    }

    /**
     * Mark rental as returned
     */
    public function markAsReturned($conditionNotes = null)
    {
        $this->update([
            'status' => 'returned',
            'returned_date' => Carbon::now(),
            'condition_notes' => $conditionNotes,
        ]);

        // Update book status back to available
        $this->book->update(['status' => 'available']);
    }
}
