<?php


namespace App\Connectors;


class SpaceConnector
{
    protected const API_URL = 'https://api.spacexdata.com/v2/launches';

    public static function fetch(array $params) :array
    {
        $requestUrl = self::API_URL;

        if (!empty($params['year'])) {
            $requestUrl .= "?start={$params['year']}-01-01&end={$params['year']}-12-31";
        }
        $limit = !empty($params['limit']) ? (int)$params['limit']: null;

        $requestData = json_decode(file_get_contents($requestUrl), true);
        return self::prepareData($requestData, $limit);
    }

    public static function prepareData(array $data, int $limit) :array
    {
        $return = [];

        foreach ($data as $index => $launch) {
            $return[] = [
                'number' => $launch['flight_number'],
                'date' => date('Y-m-d', $launch['launch_date_unix']),
                'name' => $launch['mission_name'],
                'link' => $launch['links']['article_link'],
                'details' => $launch['details']
            ];
            if (!empty($limit) && ($limit === $index + 1)) {
                break;
            }
        }

        return $return;
    }
}
