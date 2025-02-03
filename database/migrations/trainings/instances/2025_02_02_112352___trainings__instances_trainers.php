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
        Schema::create('trainings__instances_trainers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');

            $table->unsignedBigInteger('trainer_id');
            $table->foreign('trainer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('grade', 10)->nullable();
            $table->text('monitoring')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_trainers');
    }
};
