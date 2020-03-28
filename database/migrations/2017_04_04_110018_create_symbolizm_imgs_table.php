<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymbolizmImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symbolizm_images', function(Blueprint $table)
        {
            $table->increments('s_img_id');
            $table->string('img');
            $table->integer('symbolizm_idFk')->unsigned();
            $table->enum('img_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('symbolizm_images', function($table) {
            $table->foreign('symbolizm_idFk')->references('symbolizm_id')->on('symbolizm')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('symbolizm_images');
    }
}
