<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaracmsTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laracms_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'done', 'testing', 'need_information']);
            $table->integer('creator_id');
            $table->integer('project_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('laracms_task_projects')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('laracms_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laracms_tasks');
    }
}
