<?php

use Slim\Http\Request;
use Slim\Http\Response;

class RouteRiver
{
    public static function route($app)
    {

        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            return $response->withJson($db->getRiver($args['id']));
        });

        $app->get('', function (Request $request, Response $response, array $args) {
            $search = $request->getParam('search');
            $db = new DbConnection();
            return $response->withJson($db->findRivers($search));
        });

        $app->put('/{id}', function (Request $request, Response $response, array $args) {
            $river = $request->getParsedBody();
            $river = River::getFromRow($river);

            $db = new DbConnection();
            $db->updateRiver($args['id'], $river);

            $river = $db->getRiver($args['id']);
            return $response->withJson($river);
        });

        $app->post('', function (Request $request, Response $response, array $args) {

        });

        $app->delete('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            $db->deleteRiver($args['id']);
        });


    }
}
