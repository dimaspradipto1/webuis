<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use \App\Models\Concerns\HasVirtualSlug;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    /**
     * Get user roles as an array.
     */
    public function getRolesArrayAttribute(): array
    {
        if (empty($this->roles)) {
            return ['user'];
        }
        if (is_array($this->roles)) {
            return $this->roles;
        }
        if (str_starts_with($this->roles, '[') && str_ends_with($this->roles, ']')) {
            $decoded = json_decode($this->roles, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->roles))));
    }

    /**
     * Check if user has one or more roles (Admin always returns true).
     */
    public function hasRole(string|array $role): bool
    {
        $roles = $this->roles_array;
        if (in_array('admin', $roles)) {
            return true;
        }
        if (is_array($role)) {
            return ! empty(array_intersect($role, $roles));
        }

        return in_array($role, $roles);
    }

    /**
     * Check if user specifically possesses a role (without admin fallback).
     */
    public function hasExactRole(string $role): bool
    {
        return in_array($role, $this->roles_array);
    }

    public function isAdmin(): bool
    {
        return in_array('admin', $this->roles_array);
    }

    public function isPenulis(): bool
    {
        return in_array('penulis', $this->roles_array);
    }

    public function isOrganisasi(): bool
    {
        return in_array('organisasi', $this->roles_array);
    }
}
