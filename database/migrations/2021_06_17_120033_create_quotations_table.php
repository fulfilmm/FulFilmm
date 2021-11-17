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
            $table->bigInteger("customer_name")->unsigned();
            $table->foreign('customer_name')->references('id')->on('customers')->onDelete('cascade');
            $table->string("quotation_id")->unique();
            $table->timestamp("exp_date");
            $table->bigInteger("sale_person_id")->unsigned();
            $table->foreign('sale_person_id')->references('id')->on('employees')->onDelete('cascade');
            $table->tinyInteger("is_confirm");
            $table->text("terms_conditions");
            $table->double("grand_total");
            $table->string("payment_term");
            $table->double('discount')->nullable();
            $table->bigInteger('tax_id')->unsigned();
            $table->double('total');
            $table->double('tax_amount');
            $table->bigInteger('deal_id')->unsigned()->nullable();
            $table->index('id');
            $table->softDeletes();
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
