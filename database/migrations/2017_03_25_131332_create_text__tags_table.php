<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_tags', function (Blueprint $table) {
            $table->increments('t_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('text_idFk')->unsigned();
            $table->enum('t_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('text_tags', function($table) {
            $table->foreign('text_idFk')->references('text_id')->on('texts')->onDelete('restrict');
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
        Schema::dropIfExists('text_tags');
    }
}
