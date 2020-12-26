<?php

use App\Services\Gates\Providers\BaseGate;

return [
    'token' => env('GATE_AUTH_TOKEN', ''),
    'provider' => BaseGate::class,
];
