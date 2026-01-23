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
        Schema::table('users', function (Blueprint $table) {
            // Проверяем существование колонок перед удалением
            $columnsToDrop = [];
            
            if (Schema::hasColumn('users', 'phone')) {
                $columnsToDrop[] = 'phone';
            }
            if (Schema::hasColumn('users', 'phone_validated')) {
                $columnsToDrop[] = 'phone_validated';
            }
            if (Schema::hasColumn('users', 'phone_verified_at')) {
                $columnsToDrop[] = 'phone_verified_at';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->boolean('phone_validated')->default(false)->after('phone');
            $table->timestamp('phone_verified_at')->nullable()->after('phone_validated');
        });
    }
};
