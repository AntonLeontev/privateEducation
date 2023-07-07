<?php

use App\Models\Fragment;
use App\Models\Media;
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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Fragment::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->string('content_type');
			$table->date('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
