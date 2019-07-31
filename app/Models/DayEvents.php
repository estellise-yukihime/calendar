<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayEvents extends Model
{
    //


    const EVENT_DATE = 'date';
    const EVENT_DESC = 'name';

    protected $table = 'day_events';

    protected $fillable = ['date', 'description'];

    public $timestamps = false;

    protected $appends = [
        'date'
    ];


    public function month_year()
    {
        return $this->belongsTo('App\Models\MonthEvents', 'month_year_id', 'id');
    }

    function getDateAttribute()
    {
        $date = $this->month_year();
        return 12;
    }
}
