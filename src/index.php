<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';
require './models/LevelMeasurement.php';
require './services/DbConnection.php';
require './routes/RouteRiver.php';
require './routes/RouteSection.php';

$app = new App;


$app->group('/river', function () use ($app) {
    RouteRiver::route($app);
});

$app->group('/section', function () use ($app) {
    RouteSection::route($app);
});

$app->get('/dummy', function (Request $request, Response $response, array $args) {
    return $response->write('Hello on the dummy path');
});

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->write('<h1>Whitewater-Journal Backend</h1><p>This page is only for API Clients.</p>');
});

$app->run();
