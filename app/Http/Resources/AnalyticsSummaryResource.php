<?php

namespace App\Http\Resources;

use App\Enums\AnalyticMetricEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class AnalyticsSummaryResource extends JsonResource
{

    public function __construct(array $summary)
    {
        parent::__construct($summary);
    }

    public function toArray(Request $request): array
    {
        $totalClicks = $this->resource['total_clicks'];

        return [
            'totalClicks' => $totalClicks,
            'metrics' => collect($this->resource['metrics'])->map(
                fn($rows, $key) => match (AnalyticMetricEnum::from($key)) {
                    AnalyticMetricEnum::Clicks => ClickPerPeriodResource::collection($rows),
                    AnalyticMetricEnum::Devices => new DistributionDeviceResource($rows, $totalClicks),
                    default => [],
                }
            )
        ];
    }
}
