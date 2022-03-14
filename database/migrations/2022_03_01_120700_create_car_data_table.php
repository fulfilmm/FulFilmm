<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_data', function (Blueprint $table) {
            $table->id();
            $table->string('license_no');
            $table->string('brand');
            $table->string('model');
            $table->string('manufacture');
            $table->string('engine');
            $table->string('horsepower');
            $table->string('chassis');
            $table->string('kilometer') -> nullable();
            $table->string('upd_kilometer') -> nullable();
            $table->dateTime('license_issue_date') -> nullable() -> default(null);
            $table->dateTime('license_renew_date') -> nullable() -> default(null);
            $table->integer('status') -> nullable() -> change();
            $table->integer('fuel_type');
            $table->string('seat');
            $table->string('purchase_value') -> nullable();
            $table->integer('car_type');
            $table->dateTime('contract_date') -> nullable() -> default(null);
            $table->string('org_owner_name') -> nullable();
            $table->dateTime('renew_date') -> nullable() -> default(null);
            $table->string('contract')->nullable();
            $table->string('attach')->nullable();
            $table->text('description') -> nullable();
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
        Schema::dropIfExists('car_data');
    }
}
