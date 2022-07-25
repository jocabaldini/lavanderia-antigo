<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('service_item_id')->unsigned();
            $table->string('desc');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sub_items', function (Blueprint $table) {
            $table->foreign('service_item_id')->references('id')->on('service_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_items', function (Blueprint $table) {
            $table->dropForeign(['service_item_id']);
        });

        Schema::dropIfExists('sub_items');
    }
}
