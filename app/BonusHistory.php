<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class BonusHistory extends Model
{
    protected $table = 'bonus_history';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}