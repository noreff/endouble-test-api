<?php


namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ConnectorController extends Controller
{
    protected $connectorsRepositoryPath = '\App\Connectors\\';

    /**
     * Returns fetch result of the connector specified in $params['sourceId']
     *
     * @param Request $request
     * @throws Exception
     * @return array fetch result of the specified connector ($params['sourceId'])
     */
    public function fetch(Request $request) :array
    {
        try {
            $params = [
                'sourceId' => $request->input('sourceId'),
                'limit' => $request->filled(['limit']) ? $request->input('limit') : null,
                'year' => $request->filled(['year']) ? $request->input('year') : null,
            ];

            if (!$request->filled(['sourceId'])) {
                throw new Exception('Please include sourceId to your request');
            }

            $connectorName = $this->connectorsRepositoryPath . ucfirst(strtolower($request->input('sourceId'))) . 'Connector';

            // SourceId basic validation
            if (!class_exists($connectorName)) {
                throw new Exception("{$connectorName} connector class not found. Please check sourceId match connector class name.");
            }

            // Year basic validation
            if ($request->filled(['year']) && $request->input('year') < 1) {
                throw new Exception("Wrong year, should be positive integer number, `{$request->input('year')}` given");
            }

            // Limit basic validation
            if ($request->filled(['limit']) && $request->input('limit') <= 1) {
                throw new Exception("Wrong year, should be positive integer number, `{$request->input('limit')}` given");
            }



            return [
              'meta' => [
                  'request' => $params,
                  'timestamp' => date('Y-m-d\TH:i:s.000\Z')
              ],
                'data' => $connectorName::fetch($params)
            ];

        } catch (Exception $e) {
            return [
                'Error' => [
                    'Code' => $e->getCode(),
                    'Message' => $e->getMessage(),
                    'request' => !empty($params) ?: null,
                ]
            ];
        }
    }
}
