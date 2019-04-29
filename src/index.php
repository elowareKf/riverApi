<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';

$app = new App();

class template
{
    public $message;
}


$app->get('/',
    function(Request $request,  Response $response,  array $args){
    $response->write('Hello World from PHP');
});

$app->get('/dummy',
    function(Request $request, Response $response, array $args){
    $response->write('You are a dummy');
});

$app->get('/level/[{name}]', function (Request $request, Response $response, array $args) {
    $data = new template();
    $data->message = "Hello " . $args['name'];

    return $response->withJson($data);
});

$app->post('/level/[{name}]', function (Request $request, Response $response, array $args) {
    $measurement = $request->getParsedBody();




    return $response->withJson($measurement);
});

$app->run();
