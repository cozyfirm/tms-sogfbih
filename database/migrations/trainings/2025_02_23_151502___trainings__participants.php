<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trainings__participants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id')
                ->references('id')
                ->on('trainings')
                ->onDelete('cascade');

            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')
                ->references('id')
                ->on('__keywords')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__participants');
    }
};
