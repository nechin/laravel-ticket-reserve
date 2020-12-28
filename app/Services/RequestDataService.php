<?php

namespace App\Services;

use App\Services\Gates\Contracts\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;

class RequestDataService
{
    /**
     * Gate provider instance
     * @var Gate|Application|mixed
     */
    private Gate $gateProvider;

    /**
     * RequestDataService constructor.
     */
    public function __construct()
    {
        $this->gateProvider = app(Gate::class);
    }

    /**
     * Get actions
     * @return array|Collection
     */
    public function getActions()
    {
        $actions = $this->gateProvider->getActions();

        return $actions ?: [];
    }

    /**
     * Get events for action
     * @param int $actionId
     * @return array|Collection
     */
    public function getEvents(int $actionId)
    {
        $events = $this->gateProvider->getEvents($actionId);

        return $events ?: [];
    }

    /**
     * Get places for event
     * @param int $eventId
     * @return array|Collection
     */
    public function getPlaces(int $eventId)
    {
        $events = $this->gateProvider->getPlaces($eventId);

        return $events ?: [];
    }

    /**
     * Reserve a places on user name for the event
     * @param int $eventId
     * @param string $name
     * @param array $places
     * @return Collection|null
     */
    public function reservePlace(int $eventId, string $name, array $places)
    {
        $reserveId = $this->gateProvider->reservePlaces($eventId, $name, $places);

        return $reserveId ?: null;
    }
}
