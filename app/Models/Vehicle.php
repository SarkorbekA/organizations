<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $name
 * @property string $color
 * @property int $id
 * @property int $year
 * @property string $car_number
 * @property int $organization_id
 */
class Vehicle extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model',
        'color',
        'year',
        'car_number',
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function fuel_sensor(): HasMany
    {
        return $this->hasMany(FuelSensor::class);
    }
}


