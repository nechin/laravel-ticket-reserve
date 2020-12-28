<?php

namespace App\Services\Gates\Providers;

use App\Exceptions\CommonException;
use App\Services\Gates\Contracts\Gate;

class BaseGate extends Gate
{
    /**
     * Get actions from response
     * @return mixed|null
     * @throws CommonException
     */
    public function getActions()
    {
        $response = $this->makeRequest(
            'get',
            $this->apiEndpoint . 'shows'
        );

        return $this->getResponseData($response);
    }

    /**
     * Get events from response
     * @param int $actionId
     * @return mixed|null
     * @throws CommonException
     */
    public function getEvents(int $actionId)
    {
        $response = $this->makeRequest(
            'get',
            $this->apiEndpoint . 'shows/' . $actionId . '/events'
        );

        return $this->getResponseData($response);
    }

    /**
     * Get places from response
     * @param int $eventId
     * @return mixed|null
     * @throws CommonException
     */
    public function getPlaces(int $eventId)
    {
        $response = $this->makeRequest(
            'get',
            $this->apiEndpoint . 'events/' . $eventId . '/places'
        );

        return $this->getResponseData($response);
    }

    /**
     * Reserve places
     * @param int $eventId
     * @param string $name
     * @param array $places
     * @return mixed|null
     * @throws CommonException
     */
    public function reservePlaces(int $eventId, string $name, array $places): ?string
    {
        $response = $this->makeRequest(
            'post',
            $this->apiEndpoint . 'events/' . $eventId . '/reserve',
            [
                'name' => $name,
                'places' => $places,
            ]
        );

        return $this->getResponseData($response)->reservation_id ?? null;
    }

    /**
     * Get response and handle result
     * @param $response
     * @return mixed|null
     * @throws CommonException
     */
    private function getResponseData($response)
    {
        if ($response->ok()) {
            $decodedData = json_decode($response->body());

            if ($decodedData) {
                if (isset($decodedData->response)) {
                    return $decodedData->response;
                } elseif (isset($decodedData->error)) {
                    throw new CommonException('Ошибка: ' . $decodedData->error, 422);
                } else {
                    throw new CommonException('Не удалось получить ответ от ' . $this->apiEndpoint, 400);
                }
            }
        }

        return null;
    }
}
