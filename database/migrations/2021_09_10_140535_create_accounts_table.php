<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->bigInteger('head_office')->unsigned();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('account_no')->unique()->nullable();
            $table->string('number')->nullable();
            $table->string('currency')->default('MMK');
            $table->double('opening_balance', 15, 4)->default('0.0000');
            $table->double('balance', 15, 4)->default('0.0000');
            $table->string('bank_name')->nullable();
            $table->string('bank_phone')->nullable();
            $table->text('bank_address')->nullable();
            $table->boolean('enabled')->default(0);
            $table->tinyInteger('head_account')->default(0);
//            $table->bigInteger('emp_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
