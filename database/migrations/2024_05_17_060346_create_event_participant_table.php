<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventParticipantTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_participant', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('participant_came')->nullable(); // дата и время, когда участник явился на мероприятие
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participant');
    }
};
