<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class RatingMechanism extends Model
{
    protected $table = 'rating_mechanism';
    protected $primaryKey = 'id';

    public function total($table){
    return app("App\\".$table)->all();

    }
}