<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthEvents extends Model
{
    //
    protected $table = "month_events";

    public $timestamps = false;

    protected $fillable = ['date'];

    public function day_events()
    {
        return $this->hasMany('App\Models\DayEvents', 'month_year_id', 'id');
    }
}
