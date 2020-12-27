<?php


namespace App\Http\Controllers;

use App\Http\Resources\Action;
use App\Http\Resources\Event;
use App\Http\Resources\Place;
use App\Services\RequestDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EndpointController extends Controller
{
    public function actions()
    {
        $data = (new RequestDataService())->getActions();
        $this->checkEmptyValue($data, 'Мероприятий не найдено');

        return Action::collection($data);
    }

    public function events(int $actionId)
    {
        $this->checkEmptyValue($actionId, 'Мероприятие не указано');

        $data = (new RequestDataService())->getEvents($actionId);
        $this->checkEmptyValue($data, 'Событий не найдено');

        return Event::collection($data);
    }

    public function places(int $eventId)
    {
        $this->checkEmptyValue($eventId, 'Событие не указано');

        $data = (new RequestDataService())->getPlaces($eventId);
        $this->checkEmptyValue($data, 'Мест не найдено');

        return Place::collection($data);
    }

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

    private function checkEmptyValue($value, string $message): void
    {
        if (empty($value)) {
            abort(404, $message);
        }
    }
}
