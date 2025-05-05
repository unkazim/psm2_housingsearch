<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $primaryKey = 'property_id';

    protected $fillable = [
        'landlord_id',
        'title',
        'description',
        'address',
        'monthly_rent',
        'distance_from_uthm',
        'bedrooms',
        'bathrooms',
        'listed_date',
        'status',
        'preferred_gender',
        'property_type',
        'map_link' // Add this new field
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
        'distance_from_uthm' => 'decimal:2',
        'listed_date' => 'date'
    ];

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(Landlord::class, 'landlord_id', 'landlord_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class, 'property_id', 'property_id');
    }

    public function rentalApplications(): HasMany
    {
        return $this->hasMany(RentalApplication::class, 'property_id', 'property_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'property_id', 'property_id');
    }
}