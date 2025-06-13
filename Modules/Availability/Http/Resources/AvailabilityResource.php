<?php

namespace Modules\Availability\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'team' => [
                'id' => $this->team->id,
                'name' => $this->team->name,
                'tenant_id' => $this->team->tenant_id
            ],
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'day_of_week' => $this->day_of_week,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}