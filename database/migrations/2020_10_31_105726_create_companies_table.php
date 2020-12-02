<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('business_type', 64);
            $table->text('address');
            $table->string('phone', 16);
            $table->string('logo')->nullable();
            $table->json('data')->nullable();
            $table->boolean('user_company')->default(false);
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('email', 32)->nullable();
            $table->string('ceo_name', 32);
            $table->string('web_link', 128)->nullable();
            $table->string('linkedin', 128)->nullable();
            $table->string('facebook_page', 128)->nullable();
            $table->text('company_registry');
            $table->foreignId('parent_company')->nullable();
            $table->foreignId('parent_company_2')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
