<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function(Blueprint $table)
        {
            $table->increments('video_id');
            $table->string('name');
            $table->text('desc');
            $table->string('video')->nullable();
            $table->string('author')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('video_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('videos', function($table) {
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
        Schema::drop('videos');
    }
}
