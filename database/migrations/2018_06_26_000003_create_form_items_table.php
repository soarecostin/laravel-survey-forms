<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_id');

            $table->morphs('itemable');
            $table->integer('sort_order')->nullable();

            $table->tinyInteger('published')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_items');
    }
}
