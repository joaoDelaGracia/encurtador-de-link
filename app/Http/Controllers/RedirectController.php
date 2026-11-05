<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkClickFormRequest;
use App\Jobs\RegisterLinkClickJob;
use App\Services\LinkService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{

    public function __construct(private LinkService $linkService) {}

    public function __invoke(LinkClickFormRequest $request, string $slug)
    {
        $linkModel = $this->linkService->getBySlug($slug);

        RegisterLinkClickJob::dispatch($request->toDto(), $linkModel->id);

        return redirect()->away($linkModel->original_url, 302);
    }
}
