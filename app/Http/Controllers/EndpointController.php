<?php


namespace App\Http\Controllers;

use App\Http\Resources\Action;
use App\Http\Resources\Event;
use App\Services\RequestDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EndpointController extends Controller
{
    public function actions()
    {
        $data = (new RequestDataService())->getActions();
        if (!$data) {
            abort(404, 'Мероприятий не найдено');
        }

        return Action::collection($data);
    }

    public function events(int $actionId)
    {
        if (!$actionId) {
            abort(404, 'Мероприятие не указано');
        }

        $data = (new RequestDataService())->getEvents($actionId);
        if (!$data) {
            abort(404, 'Событий не найдено');
        }

        return Event::collection($data);
    }

    public function places(int $eventId)
    {
        if (!$eventId) {
            abort(404, 'Событие не указано');
        }

        $data = (new RequestDataService())->getPlaces($eventId);
        if (!$data) {
            abort(404, 'Мест не найдено');
        }

        return response()->json($data);
    }

    public function reserve(int $eventId, Request $request)
    {
        if (!$eventId) {
            abort(404, 'Событие не указано');
        }

        Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'places' => 'required|array|min:1',
        ])->validate();

        $name = $request->get('name');
        $places = $request->get('places');

        $data = (new RequestDataService())->reservePlace($eventId, $name, $places);
        if (!$data) {
            abort(404, 'Не удалось зарезервировать места');
        }

        return response()->json($data);
    }
}
