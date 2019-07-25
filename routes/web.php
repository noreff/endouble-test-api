<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Redirect;

$router->get('/', function () use ($router) {
    return [
        'project_name' => 'Endlouble Test Api',
        'version' => '1.0.0',
        'project_link' => 'https://github.com/noreff',
        'author' => 'Volodymyr Isai',
        'description' => 'API that based on a predetermined sets of fixed requests returns the correct responses',
        'endpoint' => '/api',
        'parameters' => ['sourceId' => ['space', 'comix'], 'limit' => 'Positive integer', 'year' => 'Positive integer']
    ];
});

$router->get('/api', 'ConnectorController@fetch');


