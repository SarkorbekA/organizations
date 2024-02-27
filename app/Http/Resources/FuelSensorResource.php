<?php

namespace App\Http\Resources;

use App\Models\FuelSensor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FuelSensor $resource
 */
class FuelSensorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'fuel_level' => $this->resource->fuel_level,
            'status' => $this->resource->status,
            'vehicle_id' => $this->resource->vehicle_id,
        ];
    }
}
