<?php

use Slim\Http\Request;
use Slim\Http\Response;

class RouteRiver
{
    public static function route($app)
    {
        $app->get('/levelSpots/{id}', function(Request $request, Response $response, array $args){
            $river = $args['id'];
            $db = new DbConnection();
            $result = $db->levelSpotRepository->getForRiver($river);
            return $response->withJson($result);
        });


        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            return $response->withJson($db->riverRepository->get($args['id']));
        });

        $app->get('', function (Request $request, Response $response, array $args) {
            $search = '%'.trim($request->getParam('search')).'%';

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
            $river = $request->getParsedBody();
            $river = River::getFromRow($river);

            $db = new DbConnection();
            $result = $db->riverRepository->add($river);

            return $response->withJson($result,201);
        });

        $app->delete('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            $db->riverRepository->delete($args['id']);
            return $response->withStatus(200);
        });


    }
}
