<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'originalUrl'   => $this->original_url,
            'shortCode'     => $this->short_code,
            'title'         => $this->title,
            'clicksCount'   => $this->clicks_count,
            'expiresAt'     => $this->expires_at
        ];
    }
}
