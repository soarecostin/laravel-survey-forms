<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormItemAlertTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_item_alert_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('alert_id');

            $table->string('locale')->index();

            $table->text('content');

            $table->unique(['alert_id','locale']);
            $table->foreign('alert_id')->references('id')->on('form_item_alert')->onDelete('cascade');
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
