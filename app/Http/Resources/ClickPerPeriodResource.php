<?php

namespace App\Http\Resources;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class ClickPerPeriodResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'period' => CarbonImmutable::parse($this->period)->format('d/m/Y'),
            'total' => (int) $this->total,
        ];
    }
}
