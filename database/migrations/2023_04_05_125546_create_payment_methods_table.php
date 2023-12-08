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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('link')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_country')->nullable();
            $table->string('phone_normalized')->nullable();
            $table->string('phone_national')->nullable();
            $table->string('phone_e164')->nullable()->unique();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
