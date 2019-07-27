<?php

use Slim\Http\Request;
use Slim\Http\Response;

require './models/MeasurementRaw.php';

class RouteLevelUpdate
{
    public static function route($app)
    {
        $app->post('', function (Request $request, Response $response, array $args) {
            try {
                $connection = new DbConnection();

                $update = $request->getParsedBody();

                foreach ($update as $dataSetRaw) {
                    $dataSet = MeasurementRaw::fromJson($dataSetRaw);

                    $levelSpot = $connection->levelSpotRepository->find($dataSet->riverName, $dataSet->levelSpotName);
                    if ($levelSpot == null) {
                        $levelSpot = self::addLevelSpot($connection, $dataSet->riverName, $dataSet->levelSpotName);
                        if ($levelSpot == null)
                            continue;
                    }

                    $connection->levelSpotRepository->addMeasurement($levelSpot, $dataSet->getMeasurement($levelSpot));
                }

                return $response->withStatus(200);
            } catch (Exception $exception) {
                return $response->withStatus(500, $exception->getMessage());
            }
        });
    }

    private static function addLevelSpot(DbConnection $connection, $riverName, $levelSpotName)
    {
        error_log($riverName . " " . $levelSpotName . " not found");
        $rivers = $connection->riverRepository->find($riverName);
        $river = null;

        if (array_count_values($rivers) == 0) {
            $rivers = $connection->riverRepository->get($riverName);

            if (array_count_values($rivers) == 0) {
                $river = new River();
                $river->name = $riverName;
                $river = $connection->riverRepository->add($river);
            } else {
                $river = $rivers[0];
            }

        }

        if ($river == null) return null;
        $levelSpot = $connection->levelSpotRepository->add($river->id, $levelSpotName);

        return $levelSpot;
    }
}
