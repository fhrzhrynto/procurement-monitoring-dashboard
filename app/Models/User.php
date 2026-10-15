<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Hapus import HasApiTokens
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    // Hapus HasApiTokens dari sini
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
        'profile_photo', 
        'email_verified_at',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Boot method untuk menambahkan observer
     */
    protected static function booted()
    {
        static::updating(function ($user) {
            if ($user->isDirty('remember_token')) {
                Log::info('Remember token updated for ' . $user->email . ': ' . 
                    ($user->remember_token ? substr($user->remember_token, 0, 10) . '...' : 'NULL'));
            }
        });
    }
}