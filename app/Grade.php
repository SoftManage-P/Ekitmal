<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Grade extends Model
{
    protected $table = 'grade';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}