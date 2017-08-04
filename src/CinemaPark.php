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
     * @return array
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
     * @return array
     */
    public function getMultiplexRepertoir($id)
    {
        $url = $this->endpoints['information'] . '/multiplex_repertoir/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение дополнительной информации по фильму.
     *
     * @param int $id
     *
     * @return array
     */
    public function getFilmInfo($id)
    {
        $url = $this->endpoints['information'] . '/film_info/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение списка залов по всем мультиплексам.
     *
     * @return array
     */
    public function getHalls()
    {
        $url = $this->endpoints['information'] . '/halls/';

        return $this->query($url);
    }

    /**
     * Получение списка форматов показа фильмов.
     *
     * @return array
     */
    public function getFormats()
    {
        $url = $this->endpoints['information'] . '/formats/';

        return $this->query($url);
    }

    /**
     * Комплексная выгрузка текущего расписания мультиплекса.
     *
     * @param int $id
     *
     * @return array
     */
    public function getTimeTable($id)
    {
        $url = $this->endpoints['information'] . '/timetable/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Проверка возможности начать сессию выбора мест для бронирования или покупки мест.
     *
     * @param int $multiplex_id
     * @param int $repertoir_id
     * @param int $mode
     *
     * @return array
     */
    public function checkBSession($multiplex_id, $repertoir_id, $mode)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'mode'         => $mode,
        ];
        $url = $this->endpoints['booking'] . '/check_b_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Инициализация сессии выбора мест для бронирования или покупки.
     *
     * @param int $multiplex_id
     * @param int $repertoir_id
     * @param int $mode
     *
     * @return array
     */
    public function initBSession($multiplex_id, $repertoir_id, $mode)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'mode'         => $mode,
        ];
        $url = $this->endpoints['booking'] . '/init_b_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Получение геометрической схемы зала.
     *
     * @param int $multiplex_id
     * @param int $repertoir_id
     *
     * @return array
     */
    public function seatsLayout($multiplex_id, $repertoir_id)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
        ];
        $url = $this->endpoints['booking'] . '/seats_layout/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Получение состояния мест.
     *
     * @param int    $multiplex_id
     * @param int    $repertoir_id
     * @param string $b_session_id
     * @param int    $timestamp_tz
     *
     * @return array
     */
    public function seatStates($multiplex_id, $repertoir_id, $b_session_id, $timestamp_tz = 0)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'b_session_id' => $b_session_id,
            'timestamp_tz' => $timestamp_tz,
        ];
        $url = $this->endpoints['booking'] . '/seat_states/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Действие с местом в сессии выбора мест.
     *
     * @param int    $multiplex_id
     * @param int    $repertoir_id
     * @param string $b_session_id
     * @param int    $action_type
     * @param int    $seat_id
     *
     * @return array
     */
    public function seatAction($multiplex_id, $repertoir_id, $b_session_id, $action_type, $seat_id)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'b_session_id' => $b_session_id,
            'action_type'  => $action_type,
            'seat_id'      => $seat_id,
        ];
        $url = $this->endpoints['booking'] . '/seat_action/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Отмена/закрытие сессии выбора мест.
     *
     * @param int    $multiplex_id
     * @param int    $repertoir_id
     * @param string $b_session_id
     *
     * @return array
     */
    public function cancelBSession($multiplex_id, $repertoir_id, $b_session_id)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'b_session_id' => $b_session_id,
        ];
        $url = $this->endpoints['booking'] . '/cancel_b_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Закрытие сессии выбора мест, фиксация выбора мест.
     *
     * @param int    $multiplex_id
     * @param int    $repertoir_id
     * @param string $b_session_id
     * @param int    $mode
     * @param string $email
     * @param int    $phone
     * @param int    $provider_id
     *
     * @return array
     */
    public function commitBSession($multiplex_id, $repertoir_id, $b_session_id, $mode, $email, $phone, $provider_id)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'b_session_id' => $b_session_id,
            'mode'         => $mode,
            'email'        => $email,
            'phone'        => $phone,
            'provider_id'  => $provider_id,
        ];
        $url = $this->endpoints['booking'] . '/commit_b_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Открытие сессии выбора мест после фиксации.
     *
     * @param int    $multiplex_id
     * @param int    $repertoir_id
     * @param string $codeword
     *
     * @return array
     */
    public function editBooking($multiplex_id, $repertoir_id, $codeword)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'codeword'     => $codeword,
        ];
        $url = $this->endpoints['booking'] . '/edit_booking/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Инициализация сессии оплаты.
     *
     * @param int    $multiplex_id
     * @param int    $order_id
     * @param string $codeword
     * @param int    $provider_id
     *
     * @return array
     */
    public function initSSession($multiplex_id, $order_id, $codeword, $provider_id)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'order_id'     => $order_id,
            'codeword'     => $codeword,
            'provider_id'  => $provider_id,
        ];
        $url = $this->endpoints['booking'] . '/init_s_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Фиксация факта оплаты заказа.
     *
     * @param int    $multiplex_id
     * @param int    $order_id
     * @param int    $provider_id
     * @param int    $amount
     * @param string $dt_payment
     * @param mixed  $transaction_id
     * @param string $payment_type
     * @param string $payment_info
     * @param string $security_key
     *
     * @return array
     */
    public function commitSSession($multiplex_id, $order_id, $provider_id, $amount, $dt_payment, $transaction_id, $payment_type, $payment_info, $security_key)
    {
        $params = [
            'multiplex_id'     => $multiplex_id,
            'order_id'         => $order_id,
            'provider_id'      => $provider_id,
            'amount'           => $amount,
            'dt_payment'       => $dt_payment,
            'transaction_id'   => $transaction_id,
            'payment_type'     => $payment_type,
            'payment_info'     => $payment_info,
            'security_key'     => $security_key,
        ];
        $url = $this->endpoints['booking'] . '/commit_s_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Фиксация факта неудачи оплаты заказа.
     *
     * @param int    $multiplex_id
     * @param int    $order_id
     * @param int    $provider_id
     * @param int    $amount
     * @param string $dt_payment
     * @param mixed  $transaction_id
     * @param string $payment_type
     * @param string $payment_info
     * @param string $security_key
     *
     * @return array
     */
    public function registerPaymentFailure($multiplex_id, $order_id, $provider_id, $amount, $dt_payment, $transaction_id, $payment_type, $payment_info, $security_key)
    {
        $params = [
            'multiplex_id'     => $multiplex_id,
            'order_id'         => $order_id,
            'provider_id'      => $provider_id,
            'amount'           => $amount,
            'dt_payment'       => $dt_payment,
            'transaction_id'   => $transaction_id,
            'payment_type'     => $payment_type,
            'payment_info'     => $payment_info,
            'security_key'     => $security_key,
        ];
        $url = $this->endpoints['booking'] . '/register_payment_failure/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Форматируем XML в array
     *
     * @param \SimpleXMLElement $data
     * @param array $result
     *
     * @return array
     */
    protected function normalizeSimpleXML($data, &$result) {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $res = null;
                $this->normalizeSimpleXML($value, $res);

                if (($key == '@attributes') && ($key)) {
                    $result = $res;
                } else {
                    $result[$key] = $res;
                }
            }
        } else {
            $result = $data;
        }

        return $result;
    }

    /**
     * Запрос к API
     *
     * @param string $url
     * @param string $responseType
     *
     * @return array
     * @throws CinemaParkException
     */
    protected function query($url, $responseType = 'json')
    {
        try {
            $client = new GuzzleClient();
            $response = $client->request('GET', $url);
            $result = [];

            switch ($responseType) {
                case 'xml':
                    $result = $this->normalizeSimpleXML(simplexml_load_string($response->getBody()), $result);
                    break;
                case 'json':
                    $result = json_decode($response->getBody(), true);
                    break;
            }

            return $result;
        } catch (ClientException $e) {
            throw new CinemaParkException($e->getMessage());
        }
    }
}