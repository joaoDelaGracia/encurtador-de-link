<?php

namespace App\Repositories\Eloquent;

use App\Enums\GranularityEnum;
use App\Models\Analytic;
use App\Repositories\Contracts\AnalyticRepositoryInterface;
use Carbon\CarbonInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class AnalyticRepository implements AnalyticRepositoryInterface
{

    public function create(int $linkId, DateTime $clickedAt, ?string $referrer, ?string $userAgent, string $ipHash, ?string $country, string $deviceType): void
    {
        Analytic::create([
            'link_id' => $linkId,
            'clicked_at' => $clickedAt,
            'referrer' => $referrer,
            'user_agent' => $userAgent,
            'ip_hash' => $ipHash,
            'country' => $country,
            'device_type' => $deviceType
        ]);
    }

    public function getClicksPerPeriod(int $linkId, CarbonInterface $from, CarbonInterface $to, GranularityEnum $granularity = GranularityEnum::Day, string $timezone = 'UTC'): Collection
    {
        $unit = $granularity->value;

        return Analytic::query()
            ->where('link_id', $linkId)
            ->where('clicked_at', '>=', $from)
            ->where('clicked_at', '<', $to)
            ->selectRaw(
                "date_trunc('{$unit}', clicked_at AT TIME ZONE ?) AS period, COUNT(*) AS total",
                [$timezone]
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }

    public function getTopCountries(int $idLink): Collection
    {
        return Analytic::query()
            ->where('link_id', $idLink)
            ->selectRaw("country, COUNT(*) AS total")
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();
    }

    public function getDeviceDistribution(int $idLink): Collection
    {
        return Analytic::query()
            ->where('link_id', $idLink)
            ->selectRaw("device_type, COUNT(*) AS total")
            ->groupBy('device_type')
            ->get();
    }
}
