<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyticsFilterFormRequest;
use App\Models\Link;
use App\Services\AnalyticService;
use Illuminate\Http\Request;

class LinkAnalyticsController extends Controller
{
    public function __construct(private AnalyticService $analyticService) {}

    public function summary(AnalyticsFilterFormRequest $request, int $idLink)
    {

        $analyticsSummary = $this->analyticService->getSummary($request->toDto(), $idLink);
  
    }
}
