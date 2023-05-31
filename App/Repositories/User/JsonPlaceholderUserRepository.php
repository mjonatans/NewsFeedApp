<?php

namespace App\Repositories\User;

use App\Cache;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class JsonPlaceholderUserRepository implements UserRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com/',
            'verify' => false
        ]);
    }

    public function getById(int $id): ?User
    {
        try {
            $cacheKey = 'user_' . $id;
            if (!Cache::has($cacheKey)) {
                $response = $this->client->get('users/' . $id);
                $responseContent = $response->getBody()->getContents();
                Cache::save($cacheKey, $responseContent);
            } else {
                $responseContent = Cache::get($cacheKey);
            }
            return $this->buildModel(json_decode($responseContent));
        } catch (GuzzleException $e) {
            return null;
        }
    }

    public function getAll() : array
    {
        try {
            if (!Cache::has('users')) {
                $response = $this->client->get('users');
                $responseContent = $response->getBody()->getContents();
                Cache::save('users', $responseContent);
            } else {
                $responseContent = Cache::get('users');
            }

            $userCollection = [];
            foreach (json_decode($responseContent) as $user) {
                $userCollection[] = $this->buildModel($user);

            }
            return $userCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    private function buildModel(stdClass $user) : User
    {
        return new User(
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->phone,
            $user->website
        );
    }
}