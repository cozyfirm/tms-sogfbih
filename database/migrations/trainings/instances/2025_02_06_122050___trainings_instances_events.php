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
        Schema::create('trainings__instances_events', function (Blueprint $table) {
            $table->id();

            /**
             *  1. Training
             *  2. Lunch
             */
            $table->integer('type');                     // FK to Keywords

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');

            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')
                ->references('id')
                ->on('__locations')
                ->onDelete('cascade');

            $table->date('date');
            $table->dateTime('tf__dt');                // Date + time from; Used for sorting
            $table->string('tf')->default('08:00');
            $table->string('td')->default('08:00');

            $table->text('note')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_events');
    }
};
