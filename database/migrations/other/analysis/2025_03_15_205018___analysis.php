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
        Schema::create('analysis', function (Blueprint $table) {
            $table->id();

            /** Unique token for analysis */
            $table->string('hash', 128);

            /** Analysis structure */
            $table->string('title', 200);
            $table->date('date_from');
            $table->date('date_to');
            $table->text('description');

            /** Info variables */
            $table->integer('submissions')->default(0);
            $table->integer('views')->default(0);

            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis');
    }
};
