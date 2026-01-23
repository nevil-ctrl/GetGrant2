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
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('title')->nullable()->after('course_id');
            $table->text('description')->nullable()->after('title');
            $table->string('video_url')->nullable()->after('description');
            $table->string('video_thumbnail')->nullable()->after('video_url');
            $table->foreignId('category_id')->nullable()->after('video_thumbnail');
            $table->integer('order')->default(0)->after('category_id');
            $table->boolean('is_published')->default(false)->after('order');
            // Делаем scheduled_at и meeting_link nullable, так как это для видео-уроков не обязательно
            $table->timestamp('scheduled_at')->nullable()->change();
            $table->string('meeting_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Внешний ключ удаляется в отдельной миграции
            $table->dropColumn([
                'title',
                'description',
                'video_url',
                'video_thumbnail',
                'category_id',
                'order',
                'is_published',
            ]);
            $table->timestamp('scheduled_at')->nullable(false)->change();
        });
    }
};
