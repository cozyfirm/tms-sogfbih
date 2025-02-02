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
        Schema::create('trainings__instances_lunches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');

            $table->string('restaurant', 200);
            $table->string('address', 200)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('cost', 10)->default('0.00');
            $table->integer('invoice_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_lunches');
    }
};
