<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('meeting_id')->constrained();
            $table->string('meeting_type')->nullable();
            $table->string('end_time')->nullable();
            $table->text('previous_observation')->nullable();
            $table->string('chairperson')->nullable();
            $table->text('chairperson_comment')->nullable();
            $table->unsignedBigInteger('minutes_taker')->nullable();
            $table->string('status')->default('draft');
            $table->string('user_publish_notify')->default('No');
            $table->string('week_no')->nullable();
            $table->string('access_password')->nullable();
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
        Schema::dropIfExists('minutes');
    }
};
