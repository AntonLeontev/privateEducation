<?php

use App\Models\User;
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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('country_name')->nullable();
            $table->timestamp('first_visit_at')->nullable();
            $table->timestamp('last_visit_at')->nullable();
            $table->unsignedInteger('visits_count')->default(0);
            $table->string('utm_first_source')->nullable();
            $table->string('utm_first_medium')->nullable();
            $table->string('utm_first_campaign')->nullable();
            $table->string('utm_first_term')->nullable();
            $table->string('utm_first_content')->nullable();
            $table->string('utm_last_source')->nullable();
            $table->string('utm_last_medium')->nullable();
            $table->string('utm_last_campaign')->nullable();
            $table->string('utm_last_term')->nullable();
            $table->string('utm_last_content')->nullable();
            $table->text('referrer_first')->nullable();
            $table->text('referrer_last')->nullable();
            $table->timestamps();

            $table->index('last_visit_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
