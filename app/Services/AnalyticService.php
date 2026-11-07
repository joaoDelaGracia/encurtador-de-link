<?php

namespace App\Services;

use App\Data\Link\LinkClickDto;
use App\Repositories\Contracts\AnalyticRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnalyticService
{

    private const CLICK_TTL_MINUTES = 30;

    public function __construct(
        private AnalyticRepositoryInterface $repository,
        private LinkRepositoryInterface $linkRepository
    ) {}

    public function recordClick(LinkClickDto $dto, int $linkId)
    {
        $ipHash = $this->hashIp($dto->ip);
        $keyCache = "click:{$linkId}:{$ipHash}";
        $isUnique = Cache::add($keyCache, true, now()->addMinutes(self::CLICK_TTL_MINUTES));

        try {

            DB::transaction(function () use ($dto, $linkId, $ipHash, $isUnique) {

                $this->repository->create(
                    linkId: $linkId,
                    clickedAt: $dto->clickedAt,
                    referrer: $dto->referrer,
                    userAgent: $dto->userAgent,
                    ipHash: $ipHash,
                    country: $dto->country,
                    deviceType: $dto->deviceType,
                );

                if ($isUnique) {
                    $this->linkRepository->incrementClickCount($linkId);
                }
            });
        } catch (Throwable $e) {
            Cache::forget($keyCache);
            report($e);
        }
    }

    private function hashIp(string $ip): string
    {
        return hash_hmac('sha256', $ip, config('analytics.key_ip'));
    }
}
