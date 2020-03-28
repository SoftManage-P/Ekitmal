<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function(Blueprint $table)
        {
            $table->increments('text_id');
            $table->string('name');
            $table->text('desc');
            $table->string('img')->nullable();
            $table->string('url')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('text_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('texts', function($table) {
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
        Schema::dropIfExists('texts');
    }
}
