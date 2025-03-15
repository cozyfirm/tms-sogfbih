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
        Schema::create('bodies__files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('body_id');
            $table->foreign('body_id')
                ->references('id')
                ->on('bodies')
                ->onDelete('cascade');

            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')
                ->references('id')
                ->on('__files')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodies__files');
    }
};
