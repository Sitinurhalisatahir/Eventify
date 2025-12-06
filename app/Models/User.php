<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'organizer_status', 
        'organizer_description',
        'phone',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'profile_image' => 'string'
        ];
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

        public function isApprovedOrganizer(): bool
    {
        return $this->role === 'organizer' && $this->organizer_status === 'approved';
    }

    
    public function isPendingOrganizer(): bool
    {
        return $this->role === 'organizer' && $this->organizer_status === 'pending';
    }

    public function isRejectedOrganizer(): bool
    {
        return $this->role === 'organizer' && $this->organizer_status === 'rejected';
    }
}