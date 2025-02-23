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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            /**
             *  Type of evaluation
             *      - __training
             *      - __other
             */
            $table->string('type');
            $table->bigInteger('model_id');

            /**
             *  When evaluation is locked, it is visible to users;
             *  This action cannot be undone
             */
            $table->integer('locked')->default(0);

            /** Number of submissions */
            $table->integer('submissions')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
