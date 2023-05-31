<?php

namespace App\Repositories\Post;
use App\Models\Post;

interface PostRepository
{
    public function getById(int $id): ?Post;
    public function getAll() : array;
    public function getByUserId(int $userId): array;

}