<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdsToInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->integer("receiver_id");
            $table->integer("issuer_id");
            $table->integer("payment_condition_id");
            $table->integer("bank_detail_id");
            $table->integer("contact_info_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn("receiver_id");
            $table->dropColumn("issuer_id");
            $table->dropColumn("payment_condition_id");
            $table->dropColumn("bank_detail_id");
            $table->dropColumn("contact_info_id");
        });
    }
}
