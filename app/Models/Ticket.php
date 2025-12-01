<?php

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

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable(): bool
    {
        return $this->quota_remaining > 0;
    }


    public function isSoldOut(): bool
    {
        return $this->quota_remaining <= 0;
    }

    public function getSoldCountAttribute(): int
    {
        return $this->quota - $this->quota_remaining;
    }

    public function getSoldPercentageAttribute(): float
    {
        if ($this->quota == 0) {
            return 0;
        }
        return ($this->sold_count / $this->quota) * 100;
    }

    public function decreaseQuota(int $quantity = 1): void
    {
        $this->decrement('quota_remaining', $quantity);
    }

    public function increaseQuota(int $quantity = 1): void
    {
        $this->increment('quota_remaining', $quantity);
    }
}