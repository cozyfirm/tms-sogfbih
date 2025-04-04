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
        Schema::create('trainings__instances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id')
                ->references('id')
                ->on('trainings')
                ->onDelete('cascade');

            $table->date('application_date');

            /** Description */
            $table->text('description')->nullable();

            $table->integer('total_applications')->default(0);
            $table->integer('total_males')->default(0);
            $table->integer('total_females')->default(0);
            // $table->integer('lunch');                              // FK to Keywords: Yes | No

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration')->default(0);

            $table->string('youtube', 200)->nullable();
            // $table->string('contract', 10)->default('0.00');

            // $table->string('trainer_grade', 10)->default(1.0);
            // $table->text('trainer_monitoring')->nullable();

            /* Reporting part */
            $table->integer('report')->default(0);      // FK to Keywords: Yes | No
            $table->integer('report_id')->nullable();         // ID of Uploaded file

            /* Views of training instance */
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
        Schema::dropIfExists('trainings__instances');
    }
};
