<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EventsResource;
use Carbon\Carbon;
use App\Models\MonthEvents;
use App\Http\Resources\MonthEventsResource;
use App\Http\Resources\DayEventsResources;
use App\Models\DayEvents;
use Illuminate\Support\Facades\DB;

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

        $eventCollections = collect([]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('month_events')->truncate();
        DB::table('day_events')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($dayMonth as $days) {

            $month = $days[0];
            $day = $days[1];

            $monthYear = MonthEvents::firstOrCreate(["date" => date('Y-m-d', strtotime($date . '-' . $month . '-01'))]);

            DB::beginTransaction();
            try {

                $dayEvents = new DayEvents();

                $dayEvents->month_year_id = $monthYear->id;
                $dayEvents->day = $day;
                $dayEvents->description = $description;

                $dayEvents->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }
            
            if(!$eventCollections->contains('id', $monthYear->id)){
                $eventCollections->push($monthYear);
            }
        }

        return MonthEventsResource::collection($eventCollections);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $event_dates = MonthEvents::orderBy('date', 'asc')
            ->get();


        return MonthEventsResource::collection($event_dates);
    }
}
