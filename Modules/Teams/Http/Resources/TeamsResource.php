<?php

namespace Modules\Teams\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'availability' => $this->teamAvailability->map(function ($availability) {
                return [
                    'id' => $availability->id,
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'day_of_week' => $availability->day_of_week,
                ];
            }),
            'tenant' => $this->tenant ? [
                'id' => $this->tenant->id,
                'name' => $this->tenant->name,
            ] : null,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}