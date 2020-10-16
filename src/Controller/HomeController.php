<?php

namespace App\Controller;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use App\Model\{Character, ID, Image};
use App\Model\StorageInterface;

class HomeController
{

    private $container = null;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $storage = $this->container->get(StorageInterface::class);


        return $view->render($response, 'list.html', [
            'characters' => $storage->fetchAll(),
        ]);
    }

    public function getCharacterProfile(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $storage = $this->container->get(StorageInterface::class);
        $character = $storage->fetchById(new ID($args['id']));
        return $view->render($response, 'profile.html', [
            'character' => $character,
        ]);
    }
}
