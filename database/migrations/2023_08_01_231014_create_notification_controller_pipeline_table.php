<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationControllerPipelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_controller_pipeline', function (Blueprint $table) {
                $table->bigIncrements('notification_controller_id');
                $table->unsignedBigInteger('owner_id');
                $table->integer('pre_registered')->default(0);
                $table->integer('registered')->default(0);
                $table->integer('validated')->default(0);
                $table->integer('accepted')->default(0);
                $table->integer('rejected')->default(0);
                $table->timestamps();
                $table->foreign('owner_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_controller_pipeline');
    }
}
