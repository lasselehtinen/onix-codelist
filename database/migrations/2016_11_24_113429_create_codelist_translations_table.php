<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodelistTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codelist_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('codelist_id')->unsigned();
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['codelist_id', 'locale']);
            $table->foreign('codelist_id')->references('id')->on('codelists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codelist_translations');
    }
}
