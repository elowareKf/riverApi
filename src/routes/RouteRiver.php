<?php

use Slim\Http\Request;
use Slim\Http\Response;

class RouteRiver
{
    public static function route($app)
    {

        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            return $response->withJson($db->riverRepository->get($args['id']));
        });

        $app->get('', function (Request $request, Response $response, array $args) {
            $search = $request->getParam('search');
            $db = new DbConnection();
            return $response->withJson($db->riverRepository->find($search));
        });

        $app->put('/{id}', function (Request $request, Response $response, array $args) {
            $river = $request->getParsedBody();
            $river = River::getFromRow($river);

            $db = new DbConnection();
            $db->riverRepository->update($args['id'], $river);

            $river = $db->riverRepository->get($args['id']);
            return $response->withJson($river);
        });

        $app->post('', function (Request $request, Response $response, array $args) {

        });

        $app->delete('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            $db->riverRepository->delete($args['id']);
        });


    }
}
