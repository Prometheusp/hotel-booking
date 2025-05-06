<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграций.
     * Создание таблицы типов номеров.
     */
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название типа номера
            $table->text('description'); // Описание типа номера
            $table->timestamps();
        });
    }

    /**
     * Откат миграций.
     * Удаление таблицы типов номеров.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
