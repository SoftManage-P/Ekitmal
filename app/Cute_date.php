<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Cute_date extends Model
{
    protected $table = 'cute_date';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}