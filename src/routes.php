<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class template{
    public $message;
}

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/level/[{name}]' , function (Request $request, Response $response, array $args) use ($container){
        $data = new template();
        $data->message = "Hello ".$args['name'];

        return $response->withJson($data);
    });

    $app->post('/level/[{name}]', function(Request $request, Response $response, array $args){

        $data = $request->getParsedBody();

        $data->server = "Me";

        return $response->withJson($data);
    });
/*
    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
*/
};
