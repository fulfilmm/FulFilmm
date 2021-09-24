<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailsettings', function (Blueprint $table) {
            $table->id();
            $table->string('from_address');
            $table->string('from_name');
            $table->string('mail_server');
            $table->string('host');
            $table->string('port');
            $table->string('password');
            $table->string('security');
            $table->string('auth_domain');
            $table->boolean('isactive')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailsettings');
    }
}
