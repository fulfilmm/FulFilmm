<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->unique();
            $table->text('profile')->nullable();
            $table->text('bio')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('gender');
            $table->text('address')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('can_login')->default(0);
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->dateTime('dob')->nullable();
            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->string('report_to')->nullable();
            $table->string('position_of_report_to')->nullable();
            $table->string("priority")->nullable()->nullable();
            $table->bigInteger("tags_id")->unsigned()->nullable();
            $table->foreign('tags_id')->references('id')->on('tags_industries');
            $table->bigInteger("emp_id")->unsigned();
            $table->foreign('emp_id')->references('id')->on('employees');
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->nullable();
            $table->string('lead_title')->nullable();
            $table->string('customer_type');
            $table->double('credit_limit')->default(0);
            $table->double('current_credit')->default(0);
            $table->double('advance_balance')->default(0);
            $table->string('case')->nullable();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->bigInteger('zone_id')->unsigned()->nullable();
            $table->tinyInteger('main_customer')->default(0);
            $table->double('use_amount')->default(0);
            $table->integer('payment_term')->nullable();
            $table->rememberToken();
            $table->foreignId('company_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')
                    ->on('companies')
                    ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
