<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id',
        'matric_number',
        'faculty',
        'course',
        'semester'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function rentalApplications(): HasMany
    {
        return $this->hasMany(RentalApplication::class, 'student_id', 'student_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'student_id', 'student_id');
    }
}