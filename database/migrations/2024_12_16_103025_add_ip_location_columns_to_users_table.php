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
        Schema::table('users', function (Blueprint $table) {
            $table->after('zip', function (Blueprint $table) {
                $table->string('ip')->nullable();
                $table->string('country_from_ip')->nullable();
                $table->string('country_code')->nullable();
                $table->string('region')->nullable();
                $table->string('region_code')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ip', 'country_from_ip', 'country_code', 'region', 'region_code']);
        });
    }
};
