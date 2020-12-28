<?php

use App\Services\Gates\Providers\BaseGate;

return [
    'token' => env('GATE_AUTH_TOKEN', ''),
    'api_endpoint' => env('GATE_API_ENDPOINT', ''),
    'provider' => BaseGate::class,
];
