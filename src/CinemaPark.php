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
     * Привязка фильмов к мультиплексам.
     *
     * @return array
     */
    public function getFilmsMultiplexes()
    {
        $url = $this->endpoints['information'] . '/films_multiplexes/';

        return $this->query($url);
    }

    /**
     * Получение расписания фильма.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getRepertoir($id)
    {
        $url = $this->endpoints['information'] . '/repertoir/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение расписания мультиплекса.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getMultiplexRepertoir($id)
    {
        $url = $this->endpoints['information'] . '/multiplex_repertoir/' . $id . '/';

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