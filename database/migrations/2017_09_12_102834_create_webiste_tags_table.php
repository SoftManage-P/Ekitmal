<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebisteTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('webiste_tags', function(Blueprint $table)
        {
            $table->increments('w_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('website_idFk')->unsigned();
            $table->enum('w_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('webiste_tags', function($table) {
            $table->foreign('website_idFk')->references('website_id')->on('websites')->onDelete('restrict');
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
        //
        Schema::drop('webiste_tags');
    }
}
