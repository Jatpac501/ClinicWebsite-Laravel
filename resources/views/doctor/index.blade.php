@extends('layouts.app')

@section('content')
    
    <div class="">
        <div class="">Врач {{ $doctor->speciality->name }}</div>
        <div class="">{{ $doctor->user->name }}</div>
        <div class="">Стаж: {{ $doctor->experience }} лет</div>
    </div>
    <div>
        <h2>Запись к врачу</h2>
        <form method="POST" action="{{ route('appointments.store', $doctor) }}">
            @csrf
            <div>
                <label for="time">Выберите день:</label>
                <input type="date" name="date" id="date" value="" min="" required/>
            </div>
            <div>
                <label for="time">Выберите время:</label>
                <select name="time" id="time">

                </select>
            </div>
            <div>
                <button type="submit">Записаться</button>
            </div>
        </form>
    </div>   

@endsection

@section('scripts')
    <script>
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');

        const setDate = () => {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            dateInput.min = today;
        }
        
        const loadAvailableTimes = async () => {
            try {
                const response = await fetch(`/doctor/{{ $doctor->id }}/appointments/booked-times?date=${dateInput.value}`);
                if (!response.ok) {
                    throw new Error(`Error response: ${response.status}`);
                }
                const data = await response.json();
                console.log(json);
            } catch (error) {
                console.log(error);
            }
        }

        setDate();
    </script>
@endsection