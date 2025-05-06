<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('rooms')->get();
        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'photos' => 'nullable|array'
        ]);

        $hotel = Hotel::create($validated);

        return redirect()->route('hotels.show', $hotel)
            ->with('success', 'Отель успешно создан');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load(['rooms', 'reviews']);
        return view('hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'photos' => 'nullable|array'
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.show', $hotel)
            ->with('success', 'Отель успешно обновлен');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')
            ->with('success', 'Отель успешно удален');
    }
} 