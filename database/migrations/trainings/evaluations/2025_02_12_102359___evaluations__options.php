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
        Schema::create('evaluations__options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('evaluation_id');
            $table->foreign('evaluation_id')
                ->references('id')
                ->on('evaluations')
                ->onDelete('cascade');

            /**
             *  FK to Keywords:
             *      1. Basic info
             *      2. About trainers
             *      3. ....
             */
            $table->integer('group_by');

            /**
             *  Is it question with offered answers or question with text offers
             *      - with_answers
             *      - question_only
             */
            $table->string('type')->default('with_answers');

            $table->text('question');
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations__options');
    }
};
