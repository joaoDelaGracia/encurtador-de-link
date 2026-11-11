<?php

namespace App\Repositories\Contracts;

use App\Enums\GranularityEnum;
use Carbon\CarbonInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface AnalyticRepositoryInterface
{
    public function create(int $linkId, DateTime $clickedAt, string $referrer, string $userAgent, string $ipHash, string $country, string $deviceType): void;
    public function getClicksPerPeriod(int $linkId, CarbonInterface $from, CarbonInterface $to, GranularityEnum $granularity = GranularityEnum::Day, string $timezone = 'UTC'): Collection;
}
