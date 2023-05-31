<?php

namespace App\Services\User\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Post;
use App\Repositories\Post\PostRepository;
use App\Repositories\User\UserRepository;

class ShowUserService
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct
    (
        UserRepository $userRepository,
        PostRepository $postRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function execute(ShowUserRequest $request) : ShowUserResponse
    {
        $user = $this->userRepository->getById($request->getUserId());

        if ($user == null)
        {
            throw new ResourceNotFoundException('User by ID ' . $request->getUserId() . ' not found');
        }

        $articles = $this->postRepository->getByUserId($user->getId());

        foreach ($articles as $article)
        {
            /** @var Post $article */
            $article->setAuthor(
                $this->userRepository->getById($article->getUserId())
            );
        }


        return new ShowUserResponse($user,$articles);
    }
}