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
        Schema::create('evaluations__answers', function (Blueprint $table) {
            $table->id();

            /**
             * FK to evaluations
             */
            $table->unsignedBigInteger('evaluation_id');
            $table->foreign('evaluation_id')
                ->references('id')
                ->on('evaluations')
                ->onDelete('cascade');
            /**
             *  FK to option ID
             */
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')
                ->references('id')
                ->on('evaluations__options')
                ->onDelete('cascade');

            /**
             *  FK to users
             */
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            /**
             *  Real answer:
             *      1. Number
             *      2. Textual answer
             */
            $table->string('answer', 250)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations__answers');
    }
};
