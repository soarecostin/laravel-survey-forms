<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_field_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_id');

            $table->string('name');
            $table->integer('sort_order')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('field_id')->references('id')->on('form_item_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_field_values');
    }
}
