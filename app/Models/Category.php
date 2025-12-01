<?php

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

       public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

   
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getEventsCountAttribute(): int
    {
        return $this->events()->count();
    }
}