<?php

namespace App\Repositories\Comment;
interface CommentRepository
{
    public function getByArticleId(int $articleId): array;
}