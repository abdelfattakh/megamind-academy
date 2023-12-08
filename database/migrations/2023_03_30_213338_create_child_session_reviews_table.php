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
        Schema::create('child_session_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('session_entry_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('child_id')->nullable();
            $table->string('child_name')->nullable();
            $table->boolean('attendance')->default(false);
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_session_reviews');
    }
};
