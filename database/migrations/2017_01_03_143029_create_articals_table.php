<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articals', function(Blueprint $table)
        {
            $table->increments('artical_id');
            $table->string('name');
            $table->text('desc');
            $table->string('img')->nullable();
            $table->integer('hit')->default(0);
            $table->string('url')->nullable();
            $table->string('author')->nullable();
            $table->integer('created_by')->unsigned();
            $table->enum('artical_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('articals', function($table) {
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
        Schema::drop('articals');
    }
}
