<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with(['room.hotel', 'services'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(Room $room)
    {
        return view('bookings.create', compact('room'));
    }

    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        // Проверка доступности номера
        $isAvailable = $room->isAvailableForDates(
            $validated['check_in_date'],
            $validated['check_out_date']
        );

        if (!$isAvailable) {
            return back()->withErrors(['room' => 'Номер недоступен на выбранные даты']);
        }

        // Расчет общей стоимости
        $nights = (strtotime($validated['check_out_date']) - strtotime($validated['check_in_date'])) / (60 * 60 * 24);
        $totalPrice = $room->price_per_night * $nights;

        $booking = $room->bookings()->create([
            'user_id' => Auth::id(),
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Бронирование успешно создано');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['room.hotel', 'services']);
        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Бронирование успешно отменено');
        }

        return back()->withErrors(['booking' => 'Невозможно отменить это бронирование']);
    }
} 