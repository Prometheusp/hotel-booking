<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграций.
     * Создание таблицы номеров отеля.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade'); // Связь с отелем
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade'); // Связь с типом номера
            $table->string('room_number'); // Номер комнаты
            $table->decimal('price_per_night', 10, 2); // Цена за ночь
            $table->integer('capacity'); // Вместимость номера
            $table->boolean('is_available')->default(true); // Доступность номера
            $table->timestamps();

            $table->unique(['hotel_id', 'room_number']); // Уникальный номер комнаты в пределах отеля
        });
    }

    /**
     * Откат миграций.
     * Удаление таблицы номеров.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
