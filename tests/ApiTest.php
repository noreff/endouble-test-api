<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{

    /**
     * Check if the '/' route returns expected result
     *
     * @return void
     */
    public function testIsAlive()
    {
        $this->json('GET', '/')
            ->seeJson([
                'project_name' => 'Endlouble Test Api'
            ]);
    }
}
