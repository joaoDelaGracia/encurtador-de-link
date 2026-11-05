<?php

namespace App\Repositories\Contracts;

use DateTime;

interface AnalyticRepositoryInterface
{
    public function create(int $linkId, DateTime $clickedAt, string $referrer, string $userAgent, string $ipHash, string $country, string $deviceType): void;
}
