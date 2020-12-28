<?php

namespace App\Services\Gates\Contracts;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class Gate
{
    protected string $apiEndpoint;

    /**
     * Gate constructor.
     */
    public function __construct()
    {
        $this->apiEndpoint = config('gate.api_endpoint');
    }

    /**
     * Base request handler with type application/x-www-form-urlencoded
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @return Response|null
     */
    protected function makeRequest(string $method, string $url, array $params = []): ?Response
    {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])){
            return null;
        }

        $token = config('gate.token');
        if ($token) {
            return Http::withHeaders([
                'Authorization' => 'token=' . $token
            ])->asForm()->$method($url, $params);
        } else {
            return Http::asForm()->$method($url, $params);
        }
    }

    abstract public function getActions();
    abstract public function getEvents(int $actionId);
    abstract public function getPlaces(int $eventId);
    abstract public function reservePlaces(int $eventId, string $name, array $places);
}
