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
            $table->foreignId('department_id');
            $table->string('phone', 16)->nullable();
            $table->string('email', 32)->unique()->nullable();
            $table->string('work_phone', 16)->nullable();
            $table->boolean('can_login')->default(false);
            $table->string('password', 128)->nullable();
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
