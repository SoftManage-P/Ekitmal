<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Membership extends Model
{
    protected $table = 'membership';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}