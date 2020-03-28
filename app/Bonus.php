<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Bonus extends Model
{
    protected $table = 'bonus';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}