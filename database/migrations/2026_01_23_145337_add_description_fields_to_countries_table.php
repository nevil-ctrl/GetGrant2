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
        Schema::table('countries', function (Blueprint $table) {
            if (!Schema::hasColumn('countries', 'description_ru')) {
                $table->text('description_ru')->nullable()->after('description');
            }
            if (!Schema::hasColumn('countries', 'description_en')) {
                $table->text('description_en')->nullable()->after('description_ru');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['description_ru', 'description_en']);
        });
    }
};
