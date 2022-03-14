<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintain_records', function (Blueprint $table) {
            $table->id();
            $table->Integer('status');
            $table->unsignedBigInteger('car_id');
            $table->string('case');
            $table->text('description') -> nullable();
            $table->string('kilometer');
            $table->string('workshop');
            $table->dateTime('service_date');
            $table->unsignedBigInteger('driver');
            $table->string('attaches');
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
        Schema::dropIfExists('maintain_records');
    }
}
