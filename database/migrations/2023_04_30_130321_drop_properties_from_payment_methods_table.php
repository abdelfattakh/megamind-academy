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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('phone_country');
            $table->dropColumn('phone_normalized');
            $table->dropColumn('phone_national');
            $table->dropColumn('phone_e164');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('phone_country');
            $table->string('phone_normalized');
            $table->string('phone_national');
            $table->string('phone_e164');

        });
    }
};
