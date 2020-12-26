<?php

namespace App\Services\Gates\Contracts;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class Gate
{
    protected function makeRequest(string $method, string $url, array $params = []): ?Response
    {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])){
            return null;
        }

        $token = config('gate.token');
        if ($token) {
            return Http::withHeaders([
                'Authorization' => 'token=' . $token
            ])->$method($url, $params);
        } else {
            return Http::$method($url, $params);
        }
    }

    abstract public function getActions();
    abstract public function getEvents(int $actionId);
    abstract public function getPlaces(int $eventId);
    abstract public function reservePlace(int $eventId, string $name, array $places);
}
