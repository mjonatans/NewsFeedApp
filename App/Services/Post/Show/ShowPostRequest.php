<?php

namespace App\Services\Post\Show;
class ShowPostRequest
{
    private int $articleId;
    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
    }
    public function getArticleId(): int
    {
        return $this->articleId;
    }

}