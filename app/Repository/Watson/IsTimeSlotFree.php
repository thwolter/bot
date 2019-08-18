<?php


namespace App\Repository\Watson;

use App\Repository\WatsonRepository;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

class IsTimeSlotFree extends WatsonRepository
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'startTime' => 'required',
            'minutes' => 'required|int'
        ];
    }


    public function handle()
    {
        $startDateTime = Carbon::create($this->date . $this->startTime);
        $nextEvent = Event::get($startDateTime)->first();

        $isFree = $nextEvent->startDateTime > $startDateTime->addMinutes($this->minutes);

        return ['message' => $isFree];
    }
}
