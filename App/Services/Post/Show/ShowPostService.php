<?php

namespace App\Services\Post\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Post\PostRepository;
use App\Repositories\User\UserRepository;

class ShowPostService
{
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;
    private UserRepository $userRepository;

    public function __construct
    (
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository

    )
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(ShowPostRequest $request) : ShowPostResponse
    {
        $article = $this->postRepository->getById($request->getArticleId());

        if ($article == null)
        {
            throw new ResourceNotFoundException('Article by ID ' . $request->getArticleId() . ' not found');
        }

        $author = $this->userRepository->getById($article->getUserId());

        if ($author == null)
        {
            throw new ResourceNotFoundException('Article by author ID ' . $article->getUserId() . ' not found');
        }

        $article->setAuthor($author);

        $comments = $this->commentRepository->getByArticleId($article->getId());
        return new ShowPostResponse($article,$comments);
    }
}