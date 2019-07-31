<?php

use Carbon\Carbon;



if (!function_exists('nameOfDay')) {
    function nameOfDay($oldDate, $day = 1)
    {
        $date = Carbon::parse($oldDate);

        $date = $date->addDays($day - 1);

        return $date->format('D');
    }
}
