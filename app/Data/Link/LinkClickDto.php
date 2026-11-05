<?php

namespace App\Data\Link;

use DateTime;
use Spatie\LaravelData\Data;

class LinkClickDto extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly DateTime $clickedAt,
        public readonly ?string $referrer,
        public readonly ?string $userAgent,
        public readonly string $ip,
        public readonly ?string $country,
        public readonly string $deviceType,
    ) {}
}
