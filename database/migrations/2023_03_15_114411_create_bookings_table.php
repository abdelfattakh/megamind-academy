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
        $this->down();
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();

            $table->string('phone');
            $table->string('phone_country')->nullable();
            $table->string('phone_normalized')->nullable();
            $table->string('phone_national')->nullable();
            $table->string('phone_e164')->nullable();

            $table->foreignIdFor(\App\Models\Country::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Subscription::class)->nullable()->constrained()->nullOnDelete();

            $table->string('location_of_course');
            $table->json('days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
