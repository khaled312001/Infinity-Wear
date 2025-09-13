<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'user_type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function customDesigns(): HasMany
    {
        return $this->hasMany(CustomDesign::class);
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->user_type === 'customer';
    }

    public function isImporter(): bool
    {
        return $this->user_type === 'importer';
    }

    public function hasRole(string $role): bool
    {
        return $this->user_type === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->user_type, $roles);
    }

    public function getDashboardRoute(): string
    {
        switch ($this->user_type) {
            case 'admin':
                return 'admin.dashboard';
            case 'importer':
                return 'importers.dashboard';
            case 'customer':
            default:
                return 'customer.dashboard';
        }
    }
} 