<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

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

$app->post('/level/{name}', function (Request $request, Response $response, array $args) {
    $measurement = $request->getParsedBody();




    return $response->withJson($measurement);
});


$app->run();
