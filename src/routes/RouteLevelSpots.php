<?php

use Slim\Http\Request;
use Slim\Http\Response;


class RouteLevelSpots
{
    public static function route($app)
    {
        $app->get('', function (Request $request, Response $response, array $args) {
            $riverName = $request->getParam('river');
            $levelSpotName = $request->getParam('levelSpot');
            $country = $request->getParam('country');

            $db = new DbConnection();
            $levelSpotId = $db->levelSpotRepository->find($riverName, $levelSpotName);


            if (!$levelSpotId and $country != null) {
                $river = $db->riverRepository->find($riverName);
                if (!$river) {
                    $river = new River();
                    $river->countries = $country;
                    $river->name = $riverName;

                    $river = $db->riverRepository->add($river);
                }

                $levelSpotId = $db->levelSpotRepository->add($river->id, $levelSpotName, $country);
            }

            if (!$levelSpotId)
                return $response->withStatus(404, "Nothing in database");

            $levelSpot = $db->levelSpotRepository->get($levelSpotId);
            return $response->withJson($levelSpot);
        });

        $app->get('/{id}', function (Request $request, Response $response, array $args){
            $db = new DbConnection();
            $levelSpot = $db->levelSpotRepository->get($args['id']);

            if (!$levelSpot)
                return $response->withStatus(404);
            return $response->withJson($levelSpot);
        });

        $app->post('', function (Request $request, Response $response, array $args) {

        });

        $app->post('/{id}/measurement', function (Request $request, Response $response, array $args){
            $measurement = $request->getParsedBody();
            $db = new DbConnection();
            $measurement = Measurement::fromJson($measurement);
            $db->levelSpotRepository->addMeasurement($args['id'], $measurement);

            return $response->withStatus(201);
        });
    }
}
