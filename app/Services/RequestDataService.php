<?php

namespace App\Services;

use App\Services\Gates\Contracts\Gate;

class RequestDataService
{
    private Gate $gateProvider;

    /**
     * RequestDataService constructor.
     */
    public function __construct()
    {
        $this->gateProvider = app(Gate::class);
    }

    public function getActions()
    {
        $actions = $this->gateProvider->getActions();

        return $actions ?: [];
    }

    public function getEvents(int $actionId)
    {
        $events = $this->gateProvider->getEvents($actionId);

        return $events ?: [];
    }

    public function getPlaces(int $eventId)
    {
        $events = $this->gateProvider->getPlaces($eventId);

        return $events ?: [];
    }

    public function reservePlace(int $eventId, string $name, array $places)
    {
        $reserveId = $this->gateProvider->reservePlace($eventId, $name, $places);

        return $reserveId ?: null;
    }
}
