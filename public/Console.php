<?php

namespace App\Console;

use App\Services\Post\IndexPostService;
use App\Services\User\IndexUserService;

require_once __DIR__ . "/../vendor/autoload.php";

$resource = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($resource)
{
    case 'articles' :
        if ($id != null)
        {

        } else {
            $service = new IndexPostService();
            $articles = $service->execute();

            foreach ($articles as $article) {
                echo PHP_EOL;
                echo '[ id ]: ' . $article->getId() . PHP_EOL;
                echo '[ title ]: ' . $article->getTitle() . PHP_EOL;
                echo $article->getBody() . PHP_EOL;
                echo '[ written by ]: ' . $article->getAuthor()->getName() . PHP_EOL;
                echo '__________________________________________________' . PHP_EOL;
            }

            return;
        }
        break;
    case 'users' :
        if ($id != null)
        {

        } else {
            $service = new IndexUserService();
            $users = $service->execute();

            foreach ($users as $user) {
                echo PHP_EOL;
                echo '[ id ] ' . $user->getId() . PHP_EOL;
                echo '[ name ] ' . $user->getName() . PHP_EOL;
                echo '[ username ] ' . $user->getUsername() . PHP_EOL;
                echo '[ e-mail ] ' . $user->getEmail() . PHP_EOL;
                echo '[ phone ] ' . $user->getPhone() . PHP_EOL;
                echo '__________________________________________________' . PHP_EOL;
            }

            return;
        }
        break;
    default :
        echo "something";
}