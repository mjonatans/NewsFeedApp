<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;

class IndexUserService
{
    private UserRepository $userRepository;

    public function __construct
    (
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function execute() : array
    {
        return $this->userRepository->getAll();
    }

}
