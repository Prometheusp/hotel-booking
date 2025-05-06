@extends('layouts.app')

@section('title', 'Список отелей')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Список отелей</h1>
        @auth
            <a href="{{ route('hotels.create') }}" class="btn btn-primary">Добавить отель</a>
        @endauth
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($hotels as $hotel)
            <div class="col">
                <div class="card h-100">
                    @if($hotel->photos && count($hotel->photos) > 0)
                        <img src="{{ $hotel->photos[0] }}" class="card-img-top" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">Нет фото</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                @for($i = 0; $i < $hotel->stars; $i++)
                                    ★
                                @endfor
                            </small>
                        </p>
                        <p class="card-text">{{ Str::limit($hotel->description, 100) }}</p>
                        <p class="card-text"><small class="text-muted">{{ $hotel->address }}</small></p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('hotels.show', $hotel) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection 