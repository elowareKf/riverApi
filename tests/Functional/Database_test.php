<?php

namespace Tests\Functional;

use DbConnection;
use LevelMeasurement;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use PHPUnit\Framework\TestCase;


/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class DatabaseTestCase extends TestCase
{
    function testSaveNewLevelSpot()
    {
        $connection = new DbConnection();
        $measurement = new LevelMeasurement();
        $measurement->level = 12.3;
        $measurement->firebaseUrl = "creeks/123456789/levelSpots/987654321";
        $measurement->flow = 45.3;
        $measurement->lastMeasurement = new DateTime("2010-07-05T06:00:00Z", new DateTimeZone("Europe/Amsterdam"));

        $connection->saveData($measurement);
    }
}