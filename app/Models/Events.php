<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    //
    protected $table = 'events';

    protected $fillable = ['date', 'name'];

    public $timestamps = false;



    const EVENT_DATE = 'date';
    const EVENT_DESC = 'name';
}
