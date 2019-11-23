<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormItemFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_item_fields', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type'); //input, select, textarea, checklist / "short answer", "paragraph", "checkboxes", "dropdown"
            $table->string('field_name');
            $table->boolean('required')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_item_fields');
    }
}
