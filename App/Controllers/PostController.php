<?php

namespace App\Controllers;

use App\Core\View;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Post\IndexPostService;
use App\Services\Post\Show\ShowPostRequest;
use App\Services\Post\Show\ShowPostService;

class PostController
{
    private IndexPostService $indexPostService;
    private ShowPostService $showPostService;
    public function __construct
    (
        IndexPostService $indexPostService,
        ShowPostService $showPostService
    )
    {
        $this->indexPostService = $indexPostService;
        $this->showPostService = $showPostService;
    }

    public function index() : View
    {
        $service = $this->indexPostService;
        $articles = $service->execute();
        return new View('allPosts', ['articles' => $articles]);
    }

    public function show(array $vars) : View
    {
        try {
            $articleId = $vars['id'] ?? null;
            $service = $this->showPostService;
            $response = $service->execute(new ShowPostRequest($articleId));

            return new View('singlePost', [
                'article' => $response->getPost(),
                'comments' => $response->getComments()
            ]);

        } catch (ResourceNotFoundException $exception)
        {
            return new View('notFound', []);
        }
    }
}