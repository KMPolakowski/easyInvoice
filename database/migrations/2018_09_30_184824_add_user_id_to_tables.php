<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class AddUserIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        $tables = DB::select("SHOW TABLES");


        foreach ($tables as $table) {
            if ($table->Tables_in_easyinvoice !== "user") {
                Schema::table($table->Tables_in_easyinvoice, function (Blueprint $table) {
                    $table->integer('user_id')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = DB::select("SHOW TABLES");

        foreach ($tables as $table) {
            if ($table->Tables_in_easyinvoice !== "user") {
                Schema::table($table->Tables_in_easyinvoice, function (Blueprint $table) {
                    $table->dropColumn("user_id");
                });
            }
        }
    }
}
