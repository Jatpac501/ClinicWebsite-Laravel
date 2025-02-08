@extends('layouts.app')

@section('content')
    <div class="">
        <div>Выбрать специальность</div>
        <div class="flex flex-col">
            @foreach ($specialities as $speciality)
                <a href='{{ route('search.speciality', $speciality) }}'>{{ $speciality->name }}</a>
            @endforeach
        </div>
    </div>

@endsection