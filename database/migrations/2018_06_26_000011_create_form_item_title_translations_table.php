<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormItemTitleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_item_title_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('title_id');

            $table->string('locale')->index();

            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->unique(['title_id','locale'], 'locale_title_unique');
            $table->foreign('title_id')->references('id')->on('form_item_title')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_item_title_translations');
    }
}
