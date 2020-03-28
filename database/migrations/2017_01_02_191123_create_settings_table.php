<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table)
        {
            $table->increments('setting_id');
            $table->string('name');
            $table->string('link')->nullable();
            $table->string('logo')->nullable();
            $table->text('desc')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('setting_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('settings', function($table) {
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
        Schema::drop('settings');
    }
}
