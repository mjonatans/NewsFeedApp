<?php

namespace App\Services\Post;

use App\Repositories\Post\PostRepository;
use App\Repositories\User\UserRepository;

class IndexPostService
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;
    public function __construct(
        PostRepository $postRepository,
        UserRepository $userRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function execute() : array
    {
        $articles = $this->postRepository->getAll();

        foreach ($articles as $article)
        {
            $author = $this->userRepository->getById($article->getUserId());
            $article->setAuthor($author);
        }

        return $articles;
    }

}