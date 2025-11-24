<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'description',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the events for this category.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get events count for this category.
     */
    public function getEventsCountAttribute(): int
    {
        return $this->events()->count();
    }
}