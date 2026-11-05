<?php

namespace App\Repositories\Eloquent;

use App\Models\Analytic;
use App\Repositories\Contracts\AnalyticRepositoryInterface;
use DateTime;

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

}
