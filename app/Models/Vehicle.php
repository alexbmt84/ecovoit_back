<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function findTotalSeats($vehicleId)
    {
        return self::query()->where('id', $vehicleId)
            ->value('places');
    }

}
