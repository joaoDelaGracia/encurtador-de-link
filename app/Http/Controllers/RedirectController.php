<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClickLinkFormRequest;
use App\Jobs\RegisterClickLinkJob;
use App\Services\LinkService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{

    public function __construct(private LinkService $linkService) {}

    public function __invoke(ClickLinkFormRequest $request, string $slug)
    {
        $linkModel = $this->linkService->getBySlug($slug);

        RegisterClickLinkJob::dispatch($request->toDto(), $linkModel->id);

        return redirect()->away($linkModel->original_url, 302);
    }
}
