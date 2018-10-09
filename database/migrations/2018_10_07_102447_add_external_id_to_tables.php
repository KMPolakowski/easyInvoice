<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalIdToTables extends Migration
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
            if ($table->Tables_in_easyinvoice !== "user" && $table->Tables_in_easyinvoice !== "invoice") {
                Schema::table($table->Tables_in_easyinvoice, function (Blueprint $table) {
                    $table->unsignedInteger("external_id")->default(0);
                });

                \DB::unprepared("CREATE TRIGGER ".$table->Tables_in_easyinvoice."_external_id 
                BEFORE INSERT ON ".$table->Tables_in_easyinvoice." FOR EACH ROW SET NEW.external_id =
                (SELECT IFNULL(MAX(external_id), 0) FROM ".$table->Tables_in_easyinvoice." WHERE user_id =
            NEW.user_id) +1;");
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
            if ($table->Tables_in_easyinvoice !== "user" && $table->Tables_in_easyinvoice !== "invoice") {
                \DB::unprepared("DROP TRIGGER ".$table->Tables_in_easyinvoice."_external_id");

                Schema::table($table->Tables_in_easyinvoice, function (Blueprint $table) {
                    $table->dropColumn("external_id");
                });
            }
        }
    }
}
