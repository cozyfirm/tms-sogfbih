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
        Schema::create('evaluations__statuses', function (Blueprint $table) {
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
             *  FK to users
             */
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            /**
             *  FK to user application ID
             */
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')
                ->references('id')
                ->on('trainings__instances_applications')
                ->onDelete('cascade');

            $table->string('status', '20')->default('submitted');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations__statuses');
    }
};
