<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Http\Resources\EventsResource;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->input("year");
        $dayMonth = $request->input("daysMonth");
        $description = $request->input("description") != "" ? $request->input("description") : "";

        $event_collections = collect([]);

        Events::truncate();

        foreach ($dayMonth as $day) {
            $event_collections->push(Events::firstOrCreate(["date" => date('Y-m-d', strtotime($date . '-' . $day[0] . '-' . $day[1]))], ['name' => $description]));
        }

        return EventsResource::collection($event_collections);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fromDate = null, $toDate = null)
    {
        $event_dates = null;

        if ($fromDate && $toDate) {
            $event_dates = Events::where('date', '>=', date('Y-m-d', strtotime($fromDate)))
                ->where('date', '<=', date('Y-m-d', strtotime($toDate)))
                ->orderBy('date', 'asc')
                ->get();
        } else {
            $event_dates = Events::orderBy('date', 'asc')
                ->get();
        }

        return EventsResource::collection($event_dates);
    }
}
