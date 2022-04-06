<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestForQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_for_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id')->unique();
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->bigInteger('pr_id')->unsigned()->nullable();
            $table->dateTime('receipt_date');
            $table->dateTime('deadline');
            $table->text('description')->nullable();
            $table->double('total_cost')->nullable();
            $table->string('status')->default('Daft');
            $table->bigInteger('creator_id')->unsigned();
            $table->text('vendor_reference')->nullable();
            $table->dateTime('confirm_date')->nullable();
            $table->string('type');
            $table->text('attach')->nullable();
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
        Schema::dropIfExists('request_for_quotations');
    }
}
