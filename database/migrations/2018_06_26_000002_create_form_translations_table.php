<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unique(['form_id','locale']);
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_translations');
    }
}
