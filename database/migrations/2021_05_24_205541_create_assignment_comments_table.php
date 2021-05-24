<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commenter_id')->constrained('employees');
            $table->foreignId('assignment_id')->constrained('assignments');
            $table->boolean('is_read')->default(false);
            $table->string('file')->nullable();
            $table->text('message');
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
        Schema::dropIfExists('assignment_comments');
    }
}
