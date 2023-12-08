<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workshop_entries', function (Blueprint $table) {
            $table->id();

            // Course Data.
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('course_name')->nullable();
            $table->unsignedBigInteger('level_no')->nullable();

            // Instructor Data.
            $table->foreignId('instructor_id')->nullable()->constrained('admins')->nullOnDelete()->cascadeOnUpdate();
            $table->string('instructor_name')->nullable();

            // Child Data.
            $table->unsignedBigInteger('child_id')->nullable();
            $table->string('child_name')->nullable();
            $table->string('child_phone_e164')->nullable();

            // Status.
            $table->string('status')->nullable()->default('progress');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_entries');
    }
};
