<?php

namespace Modules\Bookings\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
         
            'id' => $this->id,
            'team' => [
                'id' => $this->team->id,
                'name' => $this->team->name,
                'tenant' => [
                    'id' => $this->team->tenant->id,
                    'name' => $this->team->tenant->name,
                ],
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ],
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'date' => $this->date,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}