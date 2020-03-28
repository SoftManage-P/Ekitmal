<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_tags', function (Blueprint $table) {
            $table->increments('v_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('video_idFk')->unsigned();
            $table->enum('v_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('video_tags', function($table) {
            $table->foreign('video_idFk')->references('video_id')->on('videos')->onDelete('restrict');
            $table->foreign('tag_idFk')->references('tag_id')->on('tags')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_tags');
    }
}
