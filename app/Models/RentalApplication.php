<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalApplication extends Model
{
    protected $primaryKey = 'application_id';
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'student_id',
        'application_date',
        'status',
        'message',
        'landlord_message'
    ];

    // Cast dates to Carbon instances
    protected $casts = [
        'application_date' => 'datetime'
    ];

    // Relationship with Property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}