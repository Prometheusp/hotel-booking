<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграций.
     * Создание таблицы отзывов.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с пользователем
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade'); // Связь с отелем
            $table->integer('rating')->comment('Оценка от 1 до 5 звезд'); // Рейтинг
            $table->text('comment'); // Текст отзыва
            $table->timestamps();
        });
    }

    /**
     * Откат миграций.
     * Удаление таблицы отзывов.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
