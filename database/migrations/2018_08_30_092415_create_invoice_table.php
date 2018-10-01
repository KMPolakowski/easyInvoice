<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->smallInteger('number');
            $table->string('topic', 60);
            $table->string('street');
            $table->string('zip_code');
            $table->string('house_number');
            $table->float('netto_sum');
            $table->integer('vat_percentage');
            $table->float('vat_sum');
            $table->float('brutto_sum');
            $table->boolean("draft");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
