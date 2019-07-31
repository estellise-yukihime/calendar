<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MonthEventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'year' => Carbon::parse($this->date)->format('Y'),
            'month' => Carbon::parse($this->date)->format('m'),
            'nameOfMonth' => Carbon::parse($this->date)->format('F'),
            'totalDaysOfMonth' => Carbon::parse($this->date)->endOfMonth()->format('d'),
            'eventDays' => DayEventsResources::collection($this->day_events)
        ];
    }
}
