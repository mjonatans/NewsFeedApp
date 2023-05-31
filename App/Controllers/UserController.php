<?php

namespace App\Controllers;

use App\Core\View;
use App\Exceptions\ResourceNotFoundException;
use App\Services\User\IndexUserService;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

class UserController
{
    private IndexUserService $indexUserService;
    private ShowUserService $showUserService;

    public function __construct
    (
        IndexUserService $indexUserService,
        ShowUserService $showUserService
    )
    {
        $this->indexUserService = $indexUserService;
        $this->showUserService = $showUserService;
    }

    public function index() : View
    {
        $service = $this->indexUserService;
        $users = $service->execute();
        return new View('allUsers', ['users' => $users]);
    }

    public function show(array $vars) : View
    {
        try {
            $userId = $vars['id'] ?? null;
            $service = $this->showUserService;
            $response = $service->execute(new ShowUserRequest($userId));

            return new View('singleUser', [
                'user' => $response->getUser(),
                'articles' => $response->getArticles()
            ]);

        } catch (ResourceNotFoundException $exception)
        {
            return new View('notFound', []);
        }
    }
}