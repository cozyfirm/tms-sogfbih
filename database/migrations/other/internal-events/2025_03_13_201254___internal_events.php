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
        Schema::create('internal__events', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project');          // FK to Keywords
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')
                ->references('id')
                ->on('__locations')
                ->onDelete('cascade');
            $table->date('date');
            $table->string('time', '10')->default('00:00');

            // ToDo:: Program !??
            $table->string('youtube')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal__events');
    }
};
