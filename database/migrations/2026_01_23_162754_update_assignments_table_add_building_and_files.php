<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'building_id')) {
                $table->foreignId('building_id')->nullable()->after('lesson_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('assignments', 'due_date')) {
                $table->timestamp('due_date')->nullable()->after('description');
            }
            if (!Schema::hasColumn('assignments', 'files')) {
                $table->json('files')->nullable()->after('submission_link');
            }
            if (!Schema::hasColumn('assignments', 'images')) {
                $table->json('images')->nullable()->after('files');
            }
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
            $table->dropColumn(['building_id', 'due_date', 'files', 'images']);
        });
    }
};
