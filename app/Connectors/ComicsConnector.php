<?php


namespace App\Connectors;
use \Exception;

class ComicsConnector
{
    protected const API_URL = 'http://xkcd.com/';
    protected const API_URL_POSTFIX = 'info.0.json';

    public static function fetch(array $params) :array
    {
        $year = !empty($params['year']) ? (int)$params['year'] : null;
        $startId = $year !== null ? self::findIdInYear($year) : 1;

        $limit = !empty($params['limit']) ? (int)$params['limit']: null;

        return self::collectData($startId, $year, $limit);
    }

    private static function collectData($startId, $year = null, $limit = null) :array
    {
        $return = [];
        $counter = 0;

        if ($startId > 1) {

            // Going down from start id collecting everything that fit by year
            $id = $startId;
            do {
                if ($counter === $limit) {
                    break;
                }
                $currentIdComics = json_decode(file_get_contents(self::API_URL . $id . '/' . self::API_URL_POSTFIX), true);
                if ((int)$currentIdComics['year'] === $year) {
                    array_unshift($return, $currentIdComics);
                    $counter++;
                }
                $id--;

            } while ($id > 0 && (int)$currentIdComics['year'] === $year);

        }
        // Going up
        $id = $startId === 1 ? 1 : $startId + 1;
        $maxId = self::getMaxComicsId();
        while ($id <= $maxId) {

            if ($counter === $limit) {
                break;
            }

            $currentIdComics = json_decode(file_get_contents(self::API_URL . $id . '/' . self::API_URL_POSTFIX), true);

            if (!empty($year) && (int)$currentIdComics['year'] !== $year) {
                break;
            }
            $return[] = $currentIdComics;
            $id++;
        }
        return $return;
    }

    private static function getMaxComicsId() : int
    {
        return (int)(json_decode(file_get_contents(self::API_URL . self::API_URL_POSTFIX), true))['num'];
    }

    private static function findIdInYear($searchedYear, $previousCheckedComics = null, $idToCheck = null)
    {
        if (empty($idToCheck)) {

            $previousCheckedComics = json_decode(file_get_contents(self::API_URL . self::API_URL_POSTFIX), true);
            $maxComicsId = $previousCheckedComics['num'];
            $maxComicsYear = $previousCheckedComics['year'];

            if ($searchedYear > $maxComicsYear) {
                throw new Exception("Year should be <= {$maxComicsYear}");
            }

            $idToCheck = (int)ceil($maxComicsId / 2);
        }

        $currentComics = json_decode(file_get_contents(self::API_URL . $idToCheck . '/' . self::API_URL_POSTFIX), true);

        if ((int)$currentComics['year'] === $searchedYear) {
            return $currentComics['num'];
        }

        $step = (int)ceil(($previousCheckedComics['num'] - $idToCheck) / 2);
        if ((int)$currentComics['year'] <= $searchedYear) {
            return self::findIdInYear($searchedYear, $previousCheckedComics, ($idToCheck + $step));
        }
        return self::findIdInYear($searchedYear, $previousCheckedComics, ($idToCheck - $step));
    }

}
