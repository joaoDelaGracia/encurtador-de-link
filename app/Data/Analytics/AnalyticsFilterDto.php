<?php

namespace App\Data\Analytics;

use App\Enums\AnalyticMetricEnum;
use App\Enums\GranularityEnum;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class AnalyticsFilterDto extends Data
{
    /** 
     * @param CarbonImmutable $from
     * @param CarbonImmutable $to
     * @param GranularityEnum $granularity
     * @param string $timezone
     * @param array<AnalyticMetricEnum> $include 
     * */
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class, format: ['Y-m-d', 'Y-m-d H:i:s', DATE_ATOM])]
        public CarbonImmutable $from,
        #[WithCast(DateTimeInterfaceCast::class, format: ['Y-m-d', 'Y-m-d H:i:s', DATE_ATOM])]
        public CarbonImmutable $to,
        public GranularityEnum $granularity = GranularityEnum::Day,
        public string $timezone = 'UTC',
        public array $include = [],
    ) {}
}
