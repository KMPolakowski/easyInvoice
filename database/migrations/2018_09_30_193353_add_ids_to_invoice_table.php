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
            $table->unsignedInteger("receiver_id");
            $table->unsignedInteger("issuer_id");
            $table->unsignedInteger("payment_condition_id");
            $table->unsignedInteger("bank_detail_id");
            $table->unsignedInteger("contact_info_id");
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
