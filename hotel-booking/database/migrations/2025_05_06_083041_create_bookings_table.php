<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграций.
     * Создание таблицы бронирований.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с пользователем
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Связь с номером
            $table->date('check_in_date'); // Дата заезда
            $table->date('check_out_date'); // Дата выезда
            $table->decimal('total_price', 10, 2); // Общая стоимость
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                ->default('pending')
                ->comment('Статус бронирования: ожидает, подтверждено, отменено, завершено');
            $table->timestamps();
        });
    }

    /**
     * Откат миграций.
     * Удаление таблицы бронирований.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
