<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radios', function(Blueprint $table)
        {
            $table->increments('radio_id');
            $table->string('name');
            $table->text('desc');
            $table->string('radio')->nullable();
            $table->string('url')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('radio_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('radios', function($table) {
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
        Schema::drop('radios');
    }
}
