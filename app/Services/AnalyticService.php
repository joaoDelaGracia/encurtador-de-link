<?php

namespace App\Services;

use App\Data\Link\LinkClickDto;
use App\Repositories\Contracts\AnalyticRepositoryInterface;

class AnalyticService
{

    public function __construct(
        private AnalyticRepositoryInterface $repository
    ) {}

    public function recordClick(LinkClickDto $dto, int $linkId)
    {

        $this->repository->create(
            linkId: $linkId,
            clickedAt: $dto->clickedAt,
            referrer: $dto->referrer,
            userAgent: $dto->userAgent,
            ipHash: hash_hmac('sha256', $dto->ip, config('analytics.key_ip')),
            country: $dto->country,
            deviceType: $dto->deviceType,
        );
    }
}
