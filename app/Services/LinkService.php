<?php

namespace App\Services;

use App\Data\Link\RegisterLinkDto;
use App\Models\Link;
use App\Models\User;
use App\Repositories\Contracts\LinkRepositoryInterface;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class LinkService
{

    private const CODE_LENGTH = 8;
    private const MAX_ATTEMPTS = 5;

    public function __construct(private LinkRepositoryInterface $repository) {}

    public function create(RegisterLinkDto $dto, User $user)
    {

        for ($i = 0; $i < self::MAX_ATTEMPTS; $i++) {

            try {
                return $this->repository->create(
                    originalLink: $dto->originalUrl,
                    shortCode: Str::random(self::CODE_LENGTH),
                    title: $dto->title,
                    userId: $user->id,
                    expiresAt: $dto->expiresAt
                );
            } catch (UniqueConstraintViolationException) {
                continue;
            }
        }

        throw new RuntimeException("Não foi possível gerar um código único, tente novamente.");
    }

    public function find(int $idLink): Link
    {
        return $this->repository->find($idLink);
    }
}
