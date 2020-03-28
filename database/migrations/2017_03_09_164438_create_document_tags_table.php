<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_tags', function (Blueprint $table) {
            $table->increments('d_tag_id');
            $table->integer('tag_idFk')->unsigned();
            $table->integer('doc_idFk')->unsigned();
            $table->enum('d_tag_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('document_tags', function($table) {
            $table->foreign('doc_idFk')->references('document_id')->on('documents')->onDelete('restrict');
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
        Schema::dropIfExists('document_tags');
    }
}
