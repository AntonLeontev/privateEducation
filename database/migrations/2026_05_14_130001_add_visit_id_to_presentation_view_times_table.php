<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const UNIQUE_VISITOR_PRESENTATION_PASSIVE = 'pvt_visitor_presentation_passive_uq';

    /**
     * Run the migrations.
     *
     * Бэкфилл visit_id: минимальный visits.id для того же visitor_id.
     * Строки без подходящего визита удаляются (нет сессии/визита — счётчики не атрибутируем).
     */
    public function up(): void
    {
        if (! Schema::hasColumn('presentation_view_times', 'visit_id')) {
            Schema::table('presentation_view_times', function (Blueprint $table) {
                $table->unsignedBigInteger('visit_id')->nullable()->after('visitor_id');
            });
        }

        DB::table('presentation_view_times')
            ->orderBy('id')
            ->chunkById(500, function ($rows): void {
                foreach ($rows as $row) {
                    $visitId = DB::table('visits')
                        ->where('visitor_id', $row->visitor_id)
                        ->min('id');

                    if ($visitId !== null) {
                        DB::table('presentation_view_times')
                            ->where('id', $row->id)
                            ->update(['visit_id' => $visitId]);
                    }
                }
            });

        $orphanCount = DB::table('presentation_view_times')->whereNull('visit_id')->count();
        if ($orphanCount > 0) {
            DB::table('presentation_view_times')->whereNull('visit_id')->delete();
        }

        // Составной UNIQUE начинается с visitor_id и в MySQL может использоваться как индекс для FK visitor_id;
        // без временного снятия FK индекс не удалить.
        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->dropForeign(['visitor_id']);
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->dropUnique(self::UNIQUE_VISITOR_PRESENTATION_PASSIVE);
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors')
                ->cascadeOnDelete();
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits')
                ->cascadeOnDelete();
            $table->unique(['visit_id', 'presentation_id', 'is_passive'], 'pvt_visit_presentation_passive_uq');
            $table->unsignedBigInteger('visit_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->dropUnique('pvt_visit_presentation_passive_uq');
            $table->dropForeign(['visit_id']);
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->unsignedBigInteger('visit_id')->nullable()->change();
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->unique(['visitor_id', 'presentation_id', 'is_passive'], self::UNIQUE_VISITOR_PRESENTATION_PASSIVE);
        });

        Schema::table('presentation_view_times', function (Blueprint $table) {
            $table->dropColumn('visit_id');
        });
    }
};
