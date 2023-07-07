<?php

use App\Models\Fragment;
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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
			$table->string('title_ru');
			$table->string('title_en');
			$table->unsignedInteger('price');
			
			$table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Fragment::class)
				->constrained()
				->cascadeOnDelete()
				->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
