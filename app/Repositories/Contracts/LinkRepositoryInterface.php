<?php

namespace App\Repositories\Contracts;

use App\Models\Link;

interface LinkRepositoryInterface
{
    public function create(string $originalLink, string $shortCode, string $title, int $userId, string|null $expiresAt = null): Link;
    public function find(int $idLink): Link;
    public function getBySlug(string $slug): Link;
}
