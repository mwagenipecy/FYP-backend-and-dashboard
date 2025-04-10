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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Idea title
            $table->text('description'); // Detailed idea description
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Creator of the idea
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Idea status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
