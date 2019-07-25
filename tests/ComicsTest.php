<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ComicsTest extends TestCase
{
    /**
     * Check if the response contain data from request
     *
     * @return void
     */
    public function testResponse()
    {
        $years = range(2008, 2018);

        $year = $years[array_rand($years)];

        $this->json('GET', '/api', ['sourceId' => 'comics', 'year' => (int)$year, 'limit' => 3])
            ->seeJson([
                'year' => $year,
                'sourceId' => 'comics',
                'limit' => 3
            ]);
    }
}
