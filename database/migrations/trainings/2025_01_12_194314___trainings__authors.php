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
        Schema::create('trainings__authors', function (Blueprint $table) {
            $table->id();

            $table->integer('type');                                // FK to Keywords
            $table->string('title', 150);
            $table->string('address', 150)->nullable();
            $table->integer('city');                                // FK to cities
            $table->string('phone', 50)->nullable();
            $table->string('cellphone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__authors');
    }
};
