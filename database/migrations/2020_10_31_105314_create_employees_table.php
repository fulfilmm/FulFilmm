<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('empid')->unique();
            $table->foreignId('department_id');
            $table->string('phone', 16)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->bigInteger('report_to')->unsigned()->nullable();
            $table->dateTime('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('work_phone', 16)->nullable();
            $table->boolean('can_login')->default(false);
            $table->boolean('can_post_assignments')->default(false);
            $table->string('password', 128)->nullable();
            $table->bigInteger('office_branch_id')->nullable()->unsigned();
            $table->string('profile_img')->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->tinyInteger('mobile_seller')->default(0);// 0 is not mobile seller and 1 is mobile seller
            $table->double('amount_in_hand')->default(0);
            $table->rememberToken();
            $table->date('join_date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('department_id')
                ->on('departments')
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
        Schema::dropIfExists('employees');
    }
}
