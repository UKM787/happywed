<?php

namespace App\Models\Host;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'image',
    ];

    public function ceremonies(): BelongsToMany
    {
        return $this->belongsToMany(Ceremony::class, 'ceremony_venue');
    }
} 