<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграций.
     * Создание таблицы дополнительных услуг.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название услуги
            $table->decimal('price', 10, 2); // Стоимость услуги
            $table->text('description'); // Описание услуги
            $table->timestamps();
        });
    }

    /**
     * Откат миграций.
     * Удаление таблицы дополнительных услуг.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
