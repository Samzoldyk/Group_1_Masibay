<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('event_session_id')
                ->nullable()
                ->constrained('event_sessions')
                ->nullOnDelete();
        });

        DB::statement(
            'DROP INDEX IF EXISTS attendances_student_id_event_id_unique'
        );

        Schema::table('attendances', function (Blueprint $table) {
            $table->unique(
                ['student_id', 'event_session_id'],
                'attendances_student_id_session_id_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('attendances_student_id_session_id_unique');
            $table->dropConstrainedForeignId('event_session_id');
        });
    }
};
