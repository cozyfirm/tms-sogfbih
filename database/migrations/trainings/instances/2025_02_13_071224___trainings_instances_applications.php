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
        Schema::create('trainings__instances_applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            /**
             *  FK to Keywords:
             *      1. Pending
             *      2. Accepted
             *      3. Denied
             */
            $table->unsignedBigInteger('status')->default(1);
            $table->unsignedBigInteger('presence')->default(0);
            $table->unsignedBigInteger('certificate_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_applications');
    }
};
