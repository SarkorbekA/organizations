<?php

namespace App\Http\Resources;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Vehicle $resource
 */
class VehicleResource extends JsonResource
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
            'model' => $this->resource->model,
            'color' => $this->resource->color,
            'year' => $this->resource->year,
            'car_number' => $this->resource->car_number,
            'organization_id' => $this->resource->organization_id,
        ];
    }
}
