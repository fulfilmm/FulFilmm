<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->string('po_id');
            $table->bigInteger('pr_id')->unsigned()->nullable();
            $table->bigInteger('rfq_id')->unsigned()->nullable();
            $table->double('discount')->default(0);
            $table->double('tax_amount')->default(0);
            $table->bigInteger('tax_id')->unsigned();
            $table->double('grand_total')->default(0);
            $table->bigInteger('emp_id')->unsigned();
            $table->dateTime('receipt_date')->nullable();
            $table->text('shipping_address')->nullable();
            $table->double('additional_cost')->default(0);
            $table->tinyInteger('paid_bill')->default(0);
            $table->tinyInteger('is_receipt')->default(0);
            $table->tinyInteger('confirm')->default(0);
            $table->dateTime('confirm_date')->nullable();
            $table->tinyInteger('sent')->default(0);
            $table->string('status')->nullable();
            $table->text('attach')->nullable();
            $table->double('payable_amount')->default(0);
            $table->bigInteger('approver')->unsigned();
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
        Schema::dropIfExists('purchase_orders');
    }
}
