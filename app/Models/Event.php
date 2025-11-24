<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organizer_id',
        'category_id',
        'name',
        'description',
        'event_date',
        'location',
        'image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the organizer (user) that created this event.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the category for this event.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tickets for this event.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the bookings for this event.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the favorites for this event.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the reviews for this event.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if event is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if event is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if event is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if event date has passed.
     */
    public function isPast(): bool
    {
        return $this->event_date->isPast();
    }

    /**
     * Check if event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->event_date->isFuture();
    }

    /**
     * Get the cheapest ticket price.
     */
    public function getCheapestPriceAttribute()
    {
        return $this->tickets()->min('price') ?? 0;
    }

    /**
     * Get total available tickets.
     */
    public function getTotalAvailableTicketsAttribute(): int
    {
        return $this->tickets()->sum('quota_remaining');
    }

    /**
     * Check if event has available tickets.
     */
    public function hasAvailableTickets(): bool
    {
        return $this->total_available_tickets > 0;
    }

    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count.
     */
    public function getTotalReviewsAttribute(): int
    {
        return $this->reviews()->count();
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}