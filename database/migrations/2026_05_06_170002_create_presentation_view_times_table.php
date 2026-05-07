<?php

use App\Models\Presentation;
use App\Models\Visitor;
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
        $indexName = 'pvt_visitor_presentation_passive_uq';

        Schema::create('presentation_view_times', function (Blueprint $table) use ($indexName) {
            $table->id();
            $table->foreignIdFor(Visitor::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Presentation::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('seconds')->default(0);
            $table->boolean('is_passive')->default(false);
            $table->timestamps();

            $table->unique(['visitor_id', 'presentation_id', 'is_passive'], $indexName);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_view_times');
    }
};
