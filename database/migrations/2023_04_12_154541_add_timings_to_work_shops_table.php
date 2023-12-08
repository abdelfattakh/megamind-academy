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
        Schema::table('workshop_entries', function (Blueprint $table) {
            $table->string('day')->nullable();
            $table->string('finish_date')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_entries', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->dropColumn('finish_date');
            $table->dropColumn('start_date');
            $table->dropColumn('time');
        });
    }
};
