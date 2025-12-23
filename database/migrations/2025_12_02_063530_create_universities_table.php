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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->decimal('cost_min', 10, 2)->nullable();
            $table->decimal('cost_max', 10, 2)->nullable();
            $table->json('requirements')->nullable();
            $table->json('deadlines')->nullable();
            $table->enum('level', ['bachelor', 'master', 'phd', 'all'])->default('all');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
