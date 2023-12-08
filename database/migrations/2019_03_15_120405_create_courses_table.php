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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description');
            $table->json('prerequisites');
            $table->json('curriculum')->nullable();
            $table->decimal('price');
            $table->bigInteger('session_no');
            $table->decimal('final_price')->nullable();
            $table->boolean('is_top_course')->default(0);
            $table->json('course_location')->nullable();
            $table->json('course_bookings')->nullable();
            $table->string('udemy_course_link')->nullable();
            $table->bigInteger('discount_value')->nullable();
            $table->dateTime('discount_expiration_date')->nullable();
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
