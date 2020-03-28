<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_tags', function(Blueprint $table)
        {
            $table->increments('b_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('book_idFk')->unsigned();
            $table->enum('b_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('books_tags', function($table) {
            $table->foreign('book_idFk')->references('book_id')->on('books')->onDelete('restrict');
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
        Schema::drop('books_tags');
    }
}
