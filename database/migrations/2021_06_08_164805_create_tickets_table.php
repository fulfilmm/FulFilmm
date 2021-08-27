<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("created_emp_id")->unsigned()->nullable();
            $table->foreign("created_emp_id")->references('id')->on('employees')->onDelete('cascade');
            $table->string("ticket_id")->unique();
            $table->bigInteger("customer_id")->unsigned();
            $table->foreign("customer_id")->references("id")->on("ticket_senders")->onDelete("cascade");
            $table->index(['customer_id','created_emp_id','id']);
            $table->text("message");
            $table->string("title");
            $table->bigInteger("status")->unsigned();
            $table->foreign("status")->references('id')->on('statuses')->onDelete('cascade');
            $table->bigInteger("case_type")->unsigned();
            $table->foreign("case_type")->references('id')->on('case_types')->onDelete('cascade');
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->foreign("product_id")->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger("priority")->unsigned();
            $table->foreign("priority")->references('id')->on('priorities')->onDelete('cascade');
            $table->text("photo")->nullable();
            $table->text("attachment")->nullable();
            $table->tinyInteger("isassign")->default(1);
            $table->text('tag')->nullable();
            $table->string('source');
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
        Schema::dropIfExists('tickets');
    }
}
