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
            $table->string('phone')->nullable();
            $table->enum('role', ['student', 'parent', 'manager', 'admin'])->default('student');
            $table->enum('profile_type', ['student', 'parent'])->default('student');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn([
                'phone', 'role', 'profile_type',
                'manager_id', 'phone_verified_at',
            ]);
        });
    }
};
