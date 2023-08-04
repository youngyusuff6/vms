<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resident_id')->constrained('resident_profile');
                $table->unsignedBigInteger('registered_by')->nullable();
                $table->string('unique_id')->unique();
                $table->string('name');
                $table->string('email');
                $table->string('phone_number');
                $table->string('purpose');
                $table->date('visit_date');
                $table->time('visit_time');
                $table->timestamp('sign_in_time')->nullable();
                $table->timestamp('sign_out_time')->nullable();
                $table->string('status');
                $table->string('reg_type')->default('pre-reg');
                $table->timestamps();
    
                $table->foreign('registered_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
