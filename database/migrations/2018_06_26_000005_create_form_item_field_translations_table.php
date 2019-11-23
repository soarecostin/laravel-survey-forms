<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormItemFieldTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_item_field_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_id');

            $table->string('locale')->index();

            $table->string('label'); //label of field
            $table->string('description')->nullable();

            $table->unique(['field_id','locale']);
            $table->foreign('field_id')->references('id')->on('form_item_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_item_field_translations');
    }
}
