<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Schedule extends Model
{
    protected $table = 'evaluation_schedule';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}