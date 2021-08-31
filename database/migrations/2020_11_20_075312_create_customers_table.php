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
            $table->text('profile')->nullable();
            $table->string('name', 32);
            $table->string('phone', 16);
            $table->string('email', 32);
            $table->text('address')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('can_login')->default(0);
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('report_to')->nullable();
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
