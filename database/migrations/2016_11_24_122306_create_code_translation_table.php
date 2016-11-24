<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('code_id')->unsigned();
            $table->string('description');
            $table->longtext('notes')->nullable();
            $table->string('locale')->index();
            $table->unique(['code_id', 'locale']);
            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_translations');
    }
}
