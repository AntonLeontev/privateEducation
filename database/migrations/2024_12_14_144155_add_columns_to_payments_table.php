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
        Schema::table('payments', function (Blueprint $table) {
            $table->after('status', function (Blueprint $table) {
                $table->tinyInteger('fragment_id');
                $table->string('media_type');
                $table->timestamp('confirmed_by_webhook_at')->nullable();
                $table->timestamp('confirmed_by_redirect_at')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['fragment_id', 'media_type', 'confirmed_by_webhook_at', 'confirmed_by_redirect_at']);
        });
    }
};
