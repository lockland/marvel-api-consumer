<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use DI\ContainerBuilder;
use App\Controller\HomeController;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->usePutenv()->load(__DIR__.'/../.env');

if (file_exists(__DIR__.'/../.env.dev')) {
    $dotenv->usePutenv()->load(__DIR__.'/../.env.dev');
}

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../src/ContainerSettings.php');

AppFactory::setContainer($builder->build());
$app = AppFactory::create();
$twig = Twig::create(__DIR__ . '/../src/View', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', HomeController::class . ':index');
$app->get('/character/{id}', HomeController::class . ':getCharacterProfile')->setName('profile');

$app->run();

