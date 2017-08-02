<?php
namespace AXP\CinemaPark;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class CinemaPark
 *
 * @author  Alexander Pushkarev <axp-dev@yandex.com>
 * @link    https://github.com/axp-dev/cinemapark-api
 * @package AXP\CinemaPark
 */

class CinemaPark
{
    /**
     * Список конечных url api
     *
     * @var array
     */
    private $endpoints = [
        'information' => 'http://json.integration.www.cinemapark.ru',
        'booking'     => 'http://api.booking.www.cinemapark.ru'
    ];

    /**
     * Получение списка мультиплексов и городов.
     *
     * @return array
     */
    public function getMultiplexes()
    {
        $url = $this->endpoints['information'] . '/multiplexes/';

        return $this->query($url);
    }

    /**
     * Получение списка фильмов.
     *
     * @return array
     */
    public function getFilms()
    {
        $url = $this->endpoints['information'] . '/films/';

        return $this->query($url);
    }

    /**
     * Запрос к API
     *
     * @param string $url
     *
     * @return mixed
     * @throws CinemaParkException
     *
     */
    protected function query($url)
    {
        try {
            $client = new GuzzleClient();
            $response = $client->request('GET', $url);
            $result = json_decode($response->getBody(), true);

            return $result;
        } catch (ClientException $e) {
            throw new CinemaParkException($e->getMessage());
        }
    }
}