<?php
// app/Models/Booking.php

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

    // ==================== BOOT METHOD ====================

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate booking code saat create
        static::creating(function ($booking) {
            if (!$booking->booking_code) {
                $booking->booking_code = strtoupper(Str::random(10));
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the user that made this booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ticket for this booking.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the event through ticket.
     */
    public function event(): BelongsTo
    {
        return $this->ticket->event();
    }

    /**
     * Get the reviews for this booking.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if booking is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if booking is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if booking is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if booking is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if booking can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        // Bisa cancel jika status pending atau approved
        // dan event belum lewat
        if (!in_array($this->status, ['pending', 'approved'])) {
            return false;
        }

        return $this->ticket->event->event_date->isFuture();
    }

    /**
     * Check if user can review this booking.
     */
    public function canBeReviewed(): bool
    {
        // Bisa review jika:
        // 1. Status approved
        // 2. Event sudah lewat
        // 3. Belum pernah review
        return $this->isApproved() 
            && $this->ticket->event->event_date->isPast()
            && !$this->reviews()->exists();
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}