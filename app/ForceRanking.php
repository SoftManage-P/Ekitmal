<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class ForceRanking extends Model
{
    protected $table = 'force_rank';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}