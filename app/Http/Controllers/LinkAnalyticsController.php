<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyticsFilterFormRequest;
use App\Http\Resources\AnalyticsSummaryResource;
use App\Models\Link;
use App\Services\AnalyticService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkAnalyticsController extends Controller
{
    public function __construct(private AnalyticService $analyticService) {}

    public function summary(AnalyticsFilterFormRequest $request, Link $link)
    {

        $analyticsSummary = $this->analyticService->getSummary($request->toDto(), $link);

        return (new AnalyticsSummaryResource($analyticsSummary))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
