<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_name");
            $table->string("quotation_id")->unique();
            $table->timestamp("exp_date");
            $table->bigInteger("sale_person_id");
            $table->tinyInteger("is_confirm");
            $table->text("terms_conditions");
            $table->double("grand_total");
            $table->string("payment_term");
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
        Schema::dropIfExists('quotations');
    }
}