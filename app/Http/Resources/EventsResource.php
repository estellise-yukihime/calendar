<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EventsResource extends JsonResource
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
            'month_year' => Carbon::parse($this->date)->format('Y-m'),
            'year' => Carbon::parse($this->date)->format('Y'),
            'month_number' => Carbon::parse($this->date)->format('m'),
            'month_name' => Carbon::parse($this->date)->format('F'),
            'day_number' => Carbon::parse($this->date)->format('d'),
            'day_name' => Carbon::parse($this->date)->format('l'),
            'description' => $this->name,
        ];
    }
}
