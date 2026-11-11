<?php

namespace App\Services;

use App\Data\Analytics\AnalyticsFilterDto;
use App\Data\Link\LinkClickDto;
use App\Enums\AnalyticMetricEnum;
use App\Models\Link;
use App\Repositories\Contracts\AnalyticRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function getClicksPerPeriod(AnalyticsFilterDto $dto, int $idLink): Collection
    {
        return $this->repository->getClicksPerPeriod(
            linkId: $idLink,
            from: $dto->from,
            to: $dto->to,
            granularity: $dto->granularity,
            timezone: $dto->timezone
        );
    }

    public function getTopCountries(int $idLink): Collection
    {
        return $this->repository->getTopCountries(idLink: $idLink);
    }

    public function getDeviceDistribution(int $idLink)
    {
        return $this->repository->getDeviceDistribution(idLink: $idLink);
    }

    public function getSummary(AnalyticsFilterDto $dto, int $idLink): array
    {
        $result = [];

        foreach ($dto->include as $metric) {
            $result[$metric->value] = match ($metric) {
                AnalyticMetricEnum::Clicks => $this->getClicksPerPeriod($dto, $idLink),
                AnalyticMetricEnum::Countries => $this->getTopCountries($idLink),
                AnalyticMetricEnum::Devices => $this->getDeviceDistribution($idLink),
            };
        }

        return $result;
    }

    private function hashIp(string $ip): string
    {
        return hash_hmac('sha256', $ip, config('analytics.key_ip'));
    }
}
