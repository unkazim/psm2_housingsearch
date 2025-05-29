<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $primaryKey = 'user_id';  // Set the primary key name

    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'password',
        'user_type', // This is defined as user_type
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function landlord(): HasOne
    {
        return $this->hasOne(Landlord::class, 'user_id', 'user_id');
    }

    public function hasRole($role)
    {
        return $this->user_type === $role; // Correctly using user_type here
    }
}
