@extends('layouts.app')

@section('content')
    <h1 class="">Мед Клиника</h1>
    <div class="">
        <input type="text" name="search" id="search" placeholder="Поиск">
    </div>
    <div class="">
        <div>Поиск врачей </div>
        <div class="flex flex-col">
            @foreach ($doctors as $doctor)
                <a href="{{ route('doctor.index', $doctor) }}">{{ $doctor->user->name }}</a>
            @endforeach
            </table>
        </div>
    </div>
@endsection
