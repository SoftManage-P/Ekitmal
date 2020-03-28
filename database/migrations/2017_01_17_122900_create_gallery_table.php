<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function(Blueprint $table)
        {
            $table->increments('gallery_id');
            $table->string('name')->nullable();
            $table->string('img')->nullable();
            $table->string('url')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('gallery_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('gallery', function($table) {
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
        Schema::drop('gallery');
    }
}
