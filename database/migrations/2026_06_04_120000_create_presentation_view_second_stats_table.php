<?php

use App\Models\Presentation;
use App\Models\Visit;
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
        Schema::create('presentation_view_second_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Visit::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Presentation::class)->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('second_index');
            $table->boolean('is_passive')->default(false);
            $table->unsignedInteger('hit_count')->default(0);

            $table->unique(
                ['visit_id', 'presentation_id', 'second_index', 'is_passive'],
                'pvss_visit_presentation_second_passive_uq'
            );
            $table->index(
                ['visit_id', 'presentation_id', 'is_passive'],
                'pvss_visit_presentation_passive_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_view_second_stats');
    }
};
