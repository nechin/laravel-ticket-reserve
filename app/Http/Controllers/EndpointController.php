<?php


namespace App\Http\Controllers;

use App\Http\Resources\Action;
use App\Http\Resources\Event;
use App\Http\Resources\Place;
use App\Services\RequestDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EndpointController extends Controller
{
    /**
     * Get actions collection
     * @return AnonymousResourceCollection
     */
    public function actions()
    {
        $data = (new RequestDataService())->getActions();
        $this->checkEmptyValue($data, 'Мероприятий не найдено');

        return Action::collection($data);
    }

    /**
     * Get events collection for the action
     * @param int $actionId
     * @return AnonymousResourceCollection
     */
    public function events(int $actionId)
    {
        $this->checkEmptyValue($actionId, 'Мероприятие не указано');

        $data = (new RequestDataService())->getEvents($actionId);
        $this->checkEmptyValue($data, 'Событий не найдено');

        return Event::collection($data);
    }

    /**
     * Get places collection for the places
     * @param int $eventId
     * @return AnonymousResourceCollection
     */
    public function places(int $eventId)
    {
        $this->checkEmptyValue($eventId, 'Событие не указано');

        $data = (new RequestDataService())->getPlaces($eventId);
        $this->checkEmptyValue($data, 'Мест не найдено');

        return Place::collection($data);
    }

    /**
     * Reserve a places for the event
     * @param int $eventId
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function reserve(int $eventId, Request $request)
    {
        $this->checkEmptyValue($eventId, 'Событие не указано');

        Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'places' => 'required|array|min:1',
        ])->validate();

        $name = $request->get('name');
        $places = $request->get('places');

        $reserveId = (new RequestDataService())->reservePlace($eventId, $name, $places);
        $this->checkEmptyValue($reserveId, 'Не удалось зарезервировать места');

        return response()->json(['reserve_id' => $reserveId]);
    }

    /**
     * Check if value is empty and abort if so
     * @param $value
     * @param string $message
     */
    private function checkEmptyValue($value, string $message): void
    {
        if (empty($value)) {
            abort(404, $message);
        }
    }
}
