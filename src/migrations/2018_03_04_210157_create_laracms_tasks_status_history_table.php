<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaracmsTasksStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laracms_tasks_status_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('minutes');

            $table->foreign('task_id')->references('id')->on('laracms_tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('laracms_users')->onDelete('cascade');

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
        Schema::dropIfExists('laracms_tasks_status_history');
    }
}
