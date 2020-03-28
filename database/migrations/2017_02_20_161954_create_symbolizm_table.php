<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymbolizmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symbolizm', function(Blueprint $table)
        {
            $table->increments('symbolizm_id');
            $table->string('name')->nullable();
            $table->text('desc')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('symbolizm_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('symbolizm', function($table) {
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
        Schema::drop('symbolizm');
    }
}
