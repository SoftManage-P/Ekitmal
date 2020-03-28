<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Percent extends Model
{
    protected $table = 'percent';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}