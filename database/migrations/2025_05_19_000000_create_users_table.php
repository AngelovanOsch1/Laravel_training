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
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->default(1)->constrained('roles')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('profile_photo')->nullable();
            $table->text('profile_banner')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
