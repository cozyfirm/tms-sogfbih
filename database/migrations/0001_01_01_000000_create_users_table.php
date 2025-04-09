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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token')->nullable();
            /* Remember token for remember me */
            $table->rememberToken();

            /**
             *  Role information's:
             *      - admin
             *      - moderator
             *      - trainer
             *      - user
             */
            $table->string('role', '20')->default('user');

            /**
             *  Access to app
             *      - access
             *      - no-access
             *      - banned
             */
            $table->string('access', '20')->default('no-access');

            /* User attributes */
            $table->string('phone', 20);
            $table->date('birth_date')->nullable();
            $table->foreignId('gender');

            /* Home address data */
            $table->string('address', 100);
            $table->foreignId('city');

            /**
             *  Work place information's
             */
            $table->string('workplace', 100)->nullable();
            $table->foreignId('institution');
            /* Comment on something ?? */
            $table->text('comment')->nullable();

            /* Profile image */
            $table->string('image_id')->nullable();

            /** Number of unread notifications */
            $table->integer('notifications')->default(0);

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
