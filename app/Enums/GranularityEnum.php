<?php

namespace App\Enums;

enum GranularityEnum: string
{
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
}
