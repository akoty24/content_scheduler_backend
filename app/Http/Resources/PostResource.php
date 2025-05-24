<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image_url ? url($this->image_url) : null,
            'scheduled_time' => $this->scheduled_time?->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'platforms' => $this->platforms->map(function ($platform) {
                return [
                    'id' => $platform->id,
                    'name' => $platform->name,
                    'type' => $platform->type,
                    'status' => $platform->pivot->platform_status,
                ];
            }),
        ];
    }
}
