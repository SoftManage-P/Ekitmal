<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Objective extends Model
{
    protected $table = 'objective';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}