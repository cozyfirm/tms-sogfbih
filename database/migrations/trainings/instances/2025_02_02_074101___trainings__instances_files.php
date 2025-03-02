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
        Schema::create('trainings__instances_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')
                ->references('id')
                ->on('trainings__instances')
                ->onDelete('cascade');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')
                ->references('id')
                ->on('__files')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('views')->default(0);
            $table->string('visibility', 10)->default('private');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings__instances_files');
    }
};
