<?php

namespace App\Models;
class Post
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;
    private string $imageUrl;
    private ?User $author = null;

    public function __construct
    (
        int $id,
        int $userId,
        string $title,
        string $body,
        string $imageUrl
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getBody(): string
    {
        return $this->body;
    }


    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

}
