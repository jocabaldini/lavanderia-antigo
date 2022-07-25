<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndContactColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('address', 80)->nullable()->after('name');
            $table->string('number', 6)->nullable()->after('address');
            $table->string('address2', 80)->nullable()->after('number');
            $table->string('neighborhood', 80)->nullable()->after('address2');
            $table->string('reference', 80)->nullable()->after('neighborhood');
            $table->string('email', 80)->nullable()->after('reference');
            $table->string('cel', 11)->nullable()->after('email');
            $table->string('phone', 10)->nullable()->after('cel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('cel');
            $table->dropColumn('email');
            $table->dropColumn('reference');
            $table->dropColumn('neighborhood');
            $table->dropColumn('address2');
            $table->dropColumn('number');
            $table->dropColumn('address');
        });
    }
}
