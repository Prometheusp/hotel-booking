<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель отеля
 * 
 * @property string $name Название отеля
 * @property string $address Адрес отеля
 * @property string $description Описание отеля
 * @property int $stars Количество звезд
 * @property array $photos Массив фотографий отеля
 */
class Hotel extends Model
{
    use HasFactory;

    /**
     * Поля, доступные для массового заполнения
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'address',
        'description',
        'stars',
        'photos'
    ];

    /**
     * Приведение типов атрибутов
     *
     * @var array<string, string>
     */
    protected $casts = [
        'photos' => 'array',
        'stars' => 'integer'
    ];

    /**
     * Получить все номера отеля
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Получить все отзывы об отеле
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
