<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Kpi extends Model
{
    protected $table = 'kpi';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}