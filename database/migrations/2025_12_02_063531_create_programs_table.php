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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('university_id');
            $table->text('description')->nullable();
            $table->string('field_of_study');
            $table->boolean('is_top')->default(false);
            $table->json('career_info')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('university_id')->references('id')->on('universities')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
