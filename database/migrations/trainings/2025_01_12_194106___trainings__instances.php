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
            $table->date('date_till');

            /* Total applied to training */
            $table->unsignedInteger('men');
            $table->unsignedInteger('women');

            $table->integer('lunch');               // FK to Keywords

            $table->string('youtube', 150)->nullable();
            $table->string('cost', 20)->default('0.00');
            $table->string('trainer_cost', 20)->default('0.00');

            $table->text('trainer_monitoring')->nullable();

            $table->integer('report');              // FK to Keywords
            $table->integer('report_file_id')->nullable();

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
