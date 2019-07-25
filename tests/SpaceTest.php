<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SpaceTest extends TestCase
{
    /**
     * Check if the response contain data from request
     *
     * @return void
     */
    public function testResponse()
    {
        $years = range(2008, 2019);

        $year = $years[array_rand($years)];

        $this->json('GET', '/api', ['sourceId' => 'space', 'year' => (int)$year, 'limit' => 3])
            ->seeJson([
                'year' => $year,
                'sourceId' => 'space',
                'limit' => 3
            ]);
    }
}
