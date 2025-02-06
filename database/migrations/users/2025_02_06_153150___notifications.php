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
        Schema::create('__notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            /**
             *  1. new_profile
             *  2. new_training_registration
             *  3.
             */

            $table->string('type', '20');
            $table->unsignedBigInteger('from')->nullable();                  // For an example User ID or registration on training ID
            /* Short version of notification */
            $table->string('text', '200')->nullable();
            /* Full notification title */
            $table->text('description')->nullable();

            /** Uri to notification */
            $table->string('uri', 200)->nullable();
            $table->tinyInteger('read')->default(false);              // Is notification read or not

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__notifications');
    }
};
