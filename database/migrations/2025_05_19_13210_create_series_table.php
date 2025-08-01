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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('type')->default('TV');
            $table->string('cover_image');
            $table->string('video');
            $table->integer('episode_count');
            $table->integer('minutes_per_episode');
            $table->date('aired_start_date');
            $table->date('aired_end_date');
            $table->decimal('score', 4, 2)->default(0.00);
            $table->text('synopsis');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
