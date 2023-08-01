<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_description', function (Blueprint $table) {
                $table->bigIncrements('notification_id');
                $table->unsignedBigInteger('owner_id');
                $table->unsignedBigInteger('action_initiator_id')->nullable();
                $table->string('notification_controller_pipeline', 50);
                $table->string('notification_description', 300);
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
        Schema::dropIfExists('notification_description');
    }
}
