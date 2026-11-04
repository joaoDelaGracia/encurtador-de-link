<?php

namespace App\Repositories\Eloquent;

use App\Models\Link;
use App\Repositories\Contracts\LinkRepositoryInterface;

class LinkRepository implements LinkRepositoryInterface
{
    public function create(string $originalLink, string $shortCode, string $title, int $userId, string|null $expiresAt = null): Link
    {

        return Link::create(
            [
                'original_url' => $originalLink,
                'short_code' => $shortCode,
                'title' => $title,
                'status' => true,
                'user_id' => $userId,
                'expires_at' => $expiresAt
            ]
        );
    }

    public function find(int $idLink): Link
    {
        return Link::findOrFail($idLink);
    }

    public function getBySlug(string $slug): Link
    {
        return Link::where('short_code', $slug)->firstOrFail();
    }
}
