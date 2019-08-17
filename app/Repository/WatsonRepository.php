<?php


namespace App\Repository;


use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Spatie\GoogleCalendar\Event;

class WatsonRepository
{
    public function test(array $parameters)
    {
        $validator = Validator::make($parameters, [
            'parameter' => 'required'
        ])->validate();

        return ['message' => $parameters['parameter']];
    }


    public function proposeTimeSlot($hours)
    {
       //
    }


    public function isTimeSlotFree(array $parameters)
    {
        $validator = Validator::make($parameters, [
            'date' => 'required',
            'startTime' => 'required',
            'minutes' => 'required|int'
        ])->validate();

        $startDateTime = Carbon::create($parameters['date'] . $parameters['startTime']);
        $endtDateTime = $startDateTime->addMinutes($parameters['minutes']);

        $nextEvent = Event::get($startDateTime)->first();

        return $nextEvent->startDateTime > $endtDateTime;
    }

}
