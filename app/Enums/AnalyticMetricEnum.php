<?php

namespace App\Enums;

enum AnalyticMetricEnum: string
{
    case Clicks = 'clicks';
    case Countries = 'countries';
    case Devices = 'devices';
    case Browsers = 'browsers';
    case Referrers = 'referrers';

    public static function defaults(): array
    {
        return [self::Clicks, self::Countries, self::Devices];
    }
}
