<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}