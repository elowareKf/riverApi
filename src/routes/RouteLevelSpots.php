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

            if ((!$levelSpotId) and ($country != null)) {
                $rivers = $db->riverRepository->find($riverName);

                $river = null;

                if (count($rivers) == 0) {
                    $river = new River();
                    $river->countries = $country;
                    $river->name = $riverName;

                    $river = $db->riverRepository->add($river);
                } else {
                    $river = $rivers[0];
                }

                $levelSpotId = $db->levelSpotRepository->add($river->id, $levelSpotName, $country);
            }

            if (!$levelSpotId)
                return $response->withStatus(404, "Nothing in database");

            $levelSpot = $db->levelSpotRepository->get($levelSpotId);
            return $response->withJson($levelSpot);
        });

        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            $levelSpot = $db->levelSpotRepository->get($args['id']);

            if (!$levelSpot)
                return $response->withStatus(404);

            return $response->withJson($levelSpot);
        });

        $app->post('', function (Request $request, Response $response, array $args) {
            $river = $args['river'];
            $levelSpotName = $request->getParsedBody();

            $db = new DbConnection();
            $levelSpot = $db->levelSpotRepository->add($river, $levelSpotName->name);

            return $response->withJson($levelSpot);

        });

        $app->post('/{id}/measurement', function (Request $request, Response $response, array $args) {
            $measurement = $request->getParsedBody();
            $db = new DbConnection();
            $measurement_obj = Measurement::fromJson($measurement);
            $measurement_obj->levelSpotId = $args['id'];

            $result = $db->levelSpotRepository->addMeasurement($args['id'], $measurement_obj);

            return $response->withStatus($result ? 201 : 208);
        });

        $app->get('/{id}/measurement', function (Request $request, Response $response, array $args) {
            $id = $args['id'];
            $from = $request->getParam('from');
            $to = $request->getParam('to');

            $db = new DbConnection();

            $db->levelSpotRepository->getMeasurements($id, $from, $to);
        });
    }
}
