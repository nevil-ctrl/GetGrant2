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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('university_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();

            $table->enum('status', [
                'consultation',
                'documents',
                'submission',
                'offer',
                'visa',
                'departure',
            ])->default('consultation');

            $table->json('timeline')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('university_id')->references('id')->on('universities')->nullOnDelete();
            $table->foreign('program_id')->references('id')->on('programs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
