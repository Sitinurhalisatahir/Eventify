<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ticket_id',
        'booking_code',
        'quantity',
        'total_price',
        'status',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'cancelled_at' => 'datetime',
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_code) {
                $booking->booking_code = strtoupper(Str::random(10));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    
    public function event(): BelongsTo
    {
        return $this->ticket->event();
    }

    
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function canBeCancelled(): bool
    {
        if (!in_array($this->status, ['pending', 'approved'])) {
            return false;
        }

        return $this->ticket->event->event_date->isFuture();
    }

    public function canBeReviewed(): bool
    {
        return $this->isApproved() 
            && $this->ticket->event->event_date->isPast()
            && !$this->reviews()->exists();
    }

    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}