<?php

namespace App\Services\Gates\Providers;

use App\Services\Gates\Contracts\Gate;

class BaseGate extends Gate
{
    private string $endpoint = 'https://leadbook.ru/test-task-api/';

    public function getActions()
    {
        $response = $this->makeRequest(
            'get',
            $this->endpoint . 'shows'
        );

        return $this->getResponseData($response);
    }

    public function getEvents(int $actionId)
    {
        $response = $this->makeRequest(
            'get',
            $this->endpoint . 'shows/' . $actionId . '/events'
        );

        return $this->getResponseData($response);
    }

    public function getPlaces(int $eventId)
    {
        $response = $this->makeRequest(
            'get',
            $this->endpoint . 'events/' . $eventId . '/places'
        );

        return $this->getResponseData($response);
    }

    public function reservePlace(int $eventId, string $name, array $places)
    {
        $response = $this->makeRequest(
            'post',
            $this->endpoint . 'events/' . $eventId . '/reserve',
            [
                'name' => $name,
                'places' => $places,
            ]
        );

        return $this->getResponseData($response);
    }

    private function getResponseData($response)
    {
        if ($response->ok()) {
            $decodedData = json_decode($response->body());

            if ($decodedData && isset($decodedData->response)) {
                return $decodedData->response;
            }
        }

        return null;
    }
}
