<?php

namespace App\Services\Post\Show;
use App\Models\Post;

class ShowPostResponse
{
    private Post $post;
    private array $comments;
    public function __construct(Post $post, array $comments)
    {
        $this->post = $post;
        $this->comments = $comments;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

}