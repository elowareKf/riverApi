<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';
require './models/LevelMeasurement.php';
require './services/DbConnection.php';

$app = new App;

$app->get('/section/{id}', function(Request $request, Response $response, array $args){
    $db = new DbConnection();
    return $response->withJson($db->getSection($args['id']));
});

$app->get('/section', function (Request $request, Response $response, array $args){
    $search = $request->getParam('search');
    $db = new DbConnection();
    return $response->withJson($db->findSection($search));
});

$app->get('/river/{id}', function (Request $request, Response $response, array $args){
    $db = new DbConnection();
    return $response->withJson($db->getRiver($args['id']));
});

$app->get('/river', function(Request $request, Response $response, array $args){
    $search = $request->getParam('search');
    $db = new DbConnection();
    return $response->withJson($db->findRivers($search));
});

$app->run();
