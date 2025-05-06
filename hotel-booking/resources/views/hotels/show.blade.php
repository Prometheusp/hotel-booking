@extends('layouts.app')

@section('title', $hotel->name)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $hotel->name }}</h1>
            <p class="text-muted">
                @for($i = 0; $i < $hotel->stars; $i++)
                    ★
                @endfor
            </p>
            <p>{{ $hotel->address }}</p>
            <p>{{ $hotel->description }}</p>

            @if($hotel->photos && count($hotel->photos) > 0)
                <div id="hotelCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($hotel->photos as $index => $photo)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $photo }}" class="d-block w-100" alt="Фото отеля" style="height: 400px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @endif

            <h2>Номера</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($hotel->rooms as $room)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $room->roomType->name }}</h5>
                                <p class="card-text">
                                    <strong>Номер:</strong> {{ $room->room_number }}<br>
                                    <strong>Вместимость:</strong> {{ $room->capacity }} чел.<br>
                                    <strong>Цена за ночь:</strong> {{ number_format($room->price_per_night, 2) }} ₽
                                </p>
                                @if($room->is_available)
                                    <a href="{{ route('bookings.create', $room) }}" class="btn btn-primary">Забронировать</a>
                                @else
                                    <button class="btn btn-secondary" disabled>Недоступно</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2 class="mt-4">Отзывы</h2>
            @foreach($hotel->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $review->user->name }}</h5>
                            <small class="text-muted">
                                @for($i = 0; $i < $review->rating; $i++)
                                    ★
                                @endfor
                            </small>
                        </div>
                        <p class="card-text">{{ $review->comment }}</p>
                        <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            @auth
                <div class="card">
                    <div class="card-header">Действия</div>
                    <div class="card-body">
                        <a href="{{ route('hotels.edit', $hotel) }}" class="btn btn-primary mb-2 w-100">Редактировать</a>
                        <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection 