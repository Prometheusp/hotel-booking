<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Модель номера в отеле
 *
 * @property int $hotel_id ID отеля
 * @property int $room_type_id ID типа номера
 * @property string $room_number Номер комнаты
 * @property decimal $price_per_night Цена за ночь
 * @property int $capacity Вместимость номера
 * @property bool $is_available Доступность номера
 */
class Room extends Model
{
    use HasFactory;

    /**
     * Поля, доступные для массового заполнения
     *
     * @var array<string>
     */
    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'room_number',
        'price_per_night',
        'capacity',
        'is_available'
    ];

    /**
     * Приведение типов атрибутов
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_night' => 'decimal:2',
        'capacity' => 'integer',
        'is_available' => 'boolean'
    ];

    /**
     * Получить отель, к которому относится номер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Получить тип номера
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Получить все бронирования этого номера
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Проверить доступность номера на указанные даты
     *
     * @param string $checkIn Дата заезда
     * @param string $checkOut Дата выезда
     * @return bool
     */
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->is_available) {
            return false;
        }

        return !$this->bookings()
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
    }
}
