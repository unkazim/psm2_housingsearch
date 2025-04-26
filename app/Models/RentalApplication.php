<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalApplication extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'property_id',
        'student_id',
        'application_date',
        'status',
        'message',
        'landlord_message'
    ];

    protected $casts = [
        'application_date' => 'date'
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}