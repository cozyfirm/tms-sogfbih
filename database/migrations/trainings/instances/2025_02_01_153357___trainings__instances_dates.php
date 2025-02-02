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
        Schema::create('trainings__instances_dates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');

            $table->string('location', 200);
            $table->date('date');
            // $table->string('tf_m', 5)->default('00');
            // $table->string('tf_h', 5)->default('00');
            $table->string('tf', 5)->default('00:00');

            // $table->string('td_m', 5)->default('00');
            // $table->string('td_h', 5)->default('00');
            $table->string('td', 5)->default('00:00');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_dates');
    }
};
