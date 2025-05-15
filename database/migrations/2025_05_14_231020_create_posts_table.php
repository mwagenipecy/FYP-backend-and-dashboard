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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('type')->default('blog'); // blog, event, activity
            $table->string('status')->default('draft'); // draft, published, archived
            $table->string('featured_image')->nullable();
            $table->json('images')->nullable(); // Additional images
            $table->json('tags')->nullable();
            $table->date('event_date')->nullable(); // For events
            $table->time('event_time')->nullable(); // For events
            $table->string('event_location')->nullable(); // For events
            $table->integer('max_participants')->nullable(); // For events
            $table->text('requirements')->nullable(); // For activities/events
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['type', 'status']);
            $table->index(['published_at', 'status']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
