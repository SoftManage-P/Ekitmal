<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function(Blueprint $table)
        {
            $table->increments('book_id');
            $table->string('name');
            $table->text('desc');
            $table->string('img')->nullable();
            $table->string('pdf')->nullable();
            $table->string('author_name')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('author')->unsigned()->nullable();
            $table->enum('book_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('books', function($table) {
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('restrict');
            $table->foreign('author')->references('people_id')->on('peoples')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
