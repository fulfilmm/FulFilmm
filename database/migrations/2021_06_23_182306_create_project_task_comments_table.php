<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTaskCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_task_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commenter_id')->constrained('employees');
            $table->foreignId('project_task_id')->constrained('project_tasks');
            $table->boolean('is_read')->default(false);
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('project_task_comments');
    }
}
