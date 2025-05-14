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
        Schema::create('dynamic_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('description')->nullable();
            $table->enum('type', ['text', 'textarea', 'email', 'date', 'file', 'radio', 'checkbox', 'select']);
            $table->json('options')->nullable(); // For radio, checkbox, select
            $table->boolean('required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_questions');
    }
};
