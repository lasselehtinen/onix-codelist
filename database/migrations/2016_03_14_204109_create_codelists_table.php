<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codelists', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('number')->unsigned();
            $table->string('description');
            $table->integer('issue_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('codelists');
    }
}
