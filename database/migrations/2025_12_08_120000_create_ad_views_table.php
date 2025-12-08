<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_views', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads')->cascadeOnDelete();
            $table->date('view_date');
            $table->string('ip_hash', 64);
            $table->string('session_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['ad_id', 'view_date']);
            $table->unique(['ad_id', 'view_date', 'ip_hash', 'session_id', 'user_id'], 'ad_views_unique_daily');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_views');
    }
};
