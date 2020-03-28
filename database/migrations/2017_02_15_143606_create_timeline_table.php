<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline', function(Blueprint $table)
        {
            $table->increments('time_id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('img')->nullable();
            $table->string('video')->nullable();
            $table->string('type')->nullable();
            $table->integer('date')->signed()->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('time_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('timeline', function($table) {
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timeline');
    }
}
