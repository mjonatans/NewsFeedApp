<?php

namespace App\Repositories\Post;

use App\Cache;
use App\Models\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class JsonPlaceholderPostRepository implements PostRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com/',
            'verify' => false
        ]);
    }

    public function getById(int $id): ?Post
    {
        try {
            $cacheKey = 'article_' . $id;
            if (!Cache::has($cacheKey)) {
                $response = $this->client->get('posts/' . $id);
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
            if (!Cache::has('articles')) {
                $response = $this->client->get('posts');
                $responseContent = $response->getBody()->getContents();
                Cache::save('articles', $responseContent);
            } else {
                $responseContent = Cache::get('articles');
            }

            $postCollection = [];
            foreach (json_decode($responseContent) as $post) {
                $postCollection[] = $this->buildModel($post);
            }
            return $postCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getByUserId(int $userId): array
    {
        try {
            $cacheKey = 'articles_user_' . $userId;
            if (!Cache::has($cacheKey)) {
                $response = $this->client->get('posts?userId=' . $userId);
                $responseContent = $response->getBody()->getContents();
                Cache::save($cacheKey, $responseContent);
            } else {
                $responseContent = Cache::get($cacheKey);
            }
            $articleCollection = [];
            foreach (json_decode($responseContent) as $post) {

                $articleCollection[] = $this->buildModel($post);
            }
            return $articleCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    private function buildModel(stdClass $post) : Post
    {
        return new Post(
            $post->id,
            $post->userId,
            $post->title,
            $post->body,
            'https://placehold.co/600x400/2E3273/FFF?text=Sample+Text'
        );
    }
}