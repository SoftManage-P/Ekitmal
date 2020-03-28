<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tags', function(Blueprint $table)
        {
            $table->increments('a_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('artical_idFk')->unsigned();
            $table->enum('a_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('article_tags', function($table) {
            $table->foreign('artical_idFk')->references('artical_id')->on('articals')->onDelete('restrict');
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
        Schema::drop('article_tags');
    }
}
