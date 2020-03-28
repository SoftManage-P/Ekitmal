<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_tags', function(Blueprint $table)
        {
            $table->increments('p_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('people_idFk')->unsigned();
            $table->enum('b_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('people_tags', function($table) {
            $table->foreign('people_idFk')->references('people_id')->on('peoples')->onDelete('restrict');
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
        Schema::drop('people_tags');
    }
}
