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
        Schema::create('__locations', function (Blueprint $table) {
            $table->id();

            $table->string('title', 200);
            $table->string('address', 200);
            $table->integer('city');
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->nullable();

            /** ToDo: Maybe add a map !? */
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__locations');
    }
};
