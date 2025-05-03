<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Landlord extends Model
{
    use HasFactory;

    protected $primaryKey = 'landlord_id';

    protected $fillable = [
        'user_id',
        'bank_account',
        'ic_number',
        'approval_status', // Add this field
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'landlord_id', 'landlord_id');
    }
}