<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('service_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->enum('type', array('LAVAR','PASSAR','AMBOS'));
            $table->decimal('quantity', 5, 3);
            $table->decimal('price', 5, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('service_items', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['service_id']);
        });

        Schema::dropIfExists('service_items');
    }
}
