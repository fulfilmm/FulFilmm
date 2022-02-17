<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_id')->unique();
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->bigInteger('approver_id')->unsigned();
            $table->dateTime('deadline');
            $table->text('description')->nullable();
            $table->text('attach')->nullable();
            $table->double('total_cost');
            $table->string('status')->default('New');
            $table->bigInteger('creator_id')->unsigned();
            $table->string('type');
            $table->tinyInteger('is_prepared')->default(0);
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
        Schema::dropIfExists('purchase_requests');
    }
}
