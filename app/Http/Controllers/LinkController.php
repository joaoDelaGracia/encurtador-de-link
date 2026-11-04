<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLinkFormRequest;
use App\Http\Resources\LinkResource;
use App\Services\LinkService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends Controller
{

    public function __construct(
        private LinkService $linkService
    ) {}

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterLinkFormRequest $request)
    {
        $linkModel = $this->linkService->create($request->paraDto(), $request->user());

        return (new LinkResource($linkModel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $idLink)
    {
        $linkModel = $this->linkService->find($idLink);

        return (new LinkResource($linkModel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
