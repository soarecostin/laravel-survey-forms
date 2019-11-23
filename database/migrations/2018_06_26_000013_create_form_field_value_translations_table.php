<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldValueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_field_value_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_field_value_id');

            $table->string('locale')->index();

            $table->string('label');

            $table->unique(['form_field_value_id','locale']);
            $table->foreign('form_field_value_id')->references('id')->on('form_field_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_field_value_translations');
    }
}
