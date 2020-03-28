<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('document_id');
            $table->string('name');
            $table->text('desc');
            $table->string('pdf')->nullable();
            $table->string('author')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->enum('document_status',array(1,0))->default(1);
            $table->timestamps();
        });

        Schema::table('documents', function($table) {
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
        Schema::dropIfExists('documents');
    }
}
