<?php
// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quota',
        'quota_remaining',
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quota' => 'integer',
        'quota_remaining' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the event that owns this ticket.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the bookings for this ticket.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if ticket is available.
     */
    public function isAvailable(): bool
    {
        return $this->quota_remaining > 0;
    }

    /**
     * Check if ticket is sold out.
     */
    public function isSoldOut(): bool
    {
        return $this->quota_remaining <= 0;
    }

    /**
     * Get sold tickets count.
     */
    public function getSoldCountAttribute(): int
    {
        return $this->quota - $this->quota_remaining;
    }

    /**
     * Get sold percentage.
     */
    public function getSoldPercentageAttribute(): float
    {
        if ($this->quota == 0) {
            return 0;
        }
        return ($this->sold_count / $this->quota) * 100;
    }

    /**
     * Decrease quota (when booking is made).
     */
    public function decreaseQuota(int $quantity = 1): void
    {
        $this->decrement('quota_remaining', $quantity);
    }

    /**
     * Increase quota (when booking is cancelled).
     */
    public function increaseQuota(int $quantity = 1): void
    {
        $this->increment('quota_remaining', $quantity);
    }
}