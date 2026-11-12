<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class DistributionDeviceResource extends JsonResource
{
    public function __construct(Collection $resource, private int $totalClicks)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return $this->resource->map(fn ($item) => [
            'label' => $item->device_type,
            'total' => (int) $item->total,
            'percentage' => $this->totalClicks > 0 ? round($item->total / $this->totalClicks * 100, 1) : 0,
        ])->all();
    }
}
