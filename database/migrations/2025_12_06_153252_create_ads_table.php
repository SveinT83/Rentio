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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            // Owner
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Core fields from the form
            $table->string('ad_name');
            $table->unsignedInteger('price');
            // Pricing period: day, week, month, year
            $table->enum('price_period', ['day', 'week', 'month', 'year'])->default('day');
            $table->text('description')->nullable();

            // Category relations
            $table->foreignId('category_id')->constrained('ad_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('ad_categories')->cascadeOnUpdate()->nullOnDelete();

            // Location (simple for now)
            $table->string('location')->nullable();

            // Images (store paths or metadata as JSON)
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
