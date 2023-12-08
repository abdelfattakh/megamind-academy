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
        Schema::create('session_entries', function (Blueprint $table) {
            $table->id();

            // Instructor Data.
            $table->foreignId('instructor_id')->nullable()->constrained('admins')->nullOnDelete()->cascadeOnUpdate();
            $table->string('instructor_name')->nullable();

            // Course Data.
            $table->unsignedBigInteger('course_id')->nullable();

            // Session Data.
            $table->datetime('doc_date')->useCurrent()->nullable();
            $table->string('session_type')->default('normal'); // replacement
            $table->string('session_no')->default(1);
            $table->string('level_no')->default(1);
            $table->text('comment')->nullable();
            $table->boolean('is_level_finished')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_entries');
    }
};
