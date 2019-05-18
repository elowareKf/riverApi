<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';
require './models/LevelMeasurement.php';
require './services/DbConnection.php';

$app = new App;

class template
{
    public $message;
}


$app->get('/',
    function(Request $request,  Response $response,  array $args){
    $response->write('Hello World from PHP with SLIM');
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


$app->get('/dummy',
    function(Request $request,  Response $response,  array $args){
        $response->write('Hello Dummy from PHP with SLIM');
    });


$app->get('/level/{name}', function (Request $request, Response $response, array $args) {
    $data = new template();
    $data->message = "Hello " . $args['name'];

    return $response->withJson($data);
});

$app->get('/sections/{id}', function(Request $request, Response $response, array $args){
    $db = new DbConnection();
    return $response->withJson($db->getSection($args['id']));
});

$app->post('/level/{name}', function (Request $request, Response $response, array $args) {
    $measurement = LevelMeasurement::fromJson($request->getParsedBody());

    $measurement->flow = 12.2;
    $measurement->lastMeasurement = getdate();

    $database = new DbConnection();
    $data = $database->saveData($measurement);

    return $response->withJson($measurement);
});


$app->run();
