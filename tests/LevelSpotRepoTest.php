<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LevelSpotRepoTest extends TestCase
{

    public function getTimeDiff_test()
    {
        $data = [];
        array_push($data, new Measurement());

        $result = LevelSpotRepository::getSmallestTimeDifference($data);

        $this->assertEquals(15, $result);
    }
}
