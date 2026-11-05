<?php

namespace App\Jobs;

use App\Data\Link\LinkClickDto;
use App\Services\AnalyticService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RegisterLinkClickJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;
    public array $backoff = [10, 30, 60, 120];
    public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly LinkClickDto $dto,
        public readonly int $linkId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AnalyticService $analyticService): void
    {

        $analyticService->recordClick($this->dto, $this->linkId);
    }
}
