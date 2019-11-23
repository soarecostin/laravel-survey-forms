<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_response_id');
            $table->unsignedBigInteger('field_id');
            $table->string('field_name');
            $table->longText('value')->nullable();
            $table->timestamps();
            $table->foreign('form_response_id')->references('id')->on('form_responses');
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
        Schema::dropIfExists('form_answers');
    }
}
