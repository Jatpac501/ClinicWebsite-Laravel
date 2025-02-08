@extends('layouts.app')

@section('content')
    
    <div class="">
        <div class="">Врач {{ $doctor->speciality->name }}</div>
        <div class="">{{ $doctor->user->name }}</div>
        <div class="">Стаж: {{ $doctor->experience }} лет</div>
    </div>
    <div>
        <h2>Запись к врачу</h2>
        <form method="POST" action="{{ route('appointments.store', $doctor->id) }}">
            @csrf
            <div>
                <label for="time">Выберите день:</label>
                <input type="date" name="date" id="date" value="" min="" required/>
            </div>
            <div>
                <label for="time">Выберите время:</label>
                <select name="time" id="time" required>Выберите время</select>
            </div>
            <div>
                <button type="submit">Записаться</button>
            </div>
        </form>
    </div>   

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('date');
            const timeInput = document.getElementById('time');

            const setDate = () => {
                const today = new Date().toISOString().split('T')[0];
                dateInput.value = today;
                dateInput.min = today;
                loadAvailableTimes();
            }
            const loadAvailableTimes = async () => {
                timeInput.innerHTML = '<option>Загрузка...</option>';
                try {
                    const response = await fetch(`/doctor/{{ $doctor->id }}/appointments/booked-times?date=${dateInput.value}`);
                    if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
                    const bookedTimes = await response.json();

                    const availableTimes = genTimeSlots();

                    timeInput.innerHTML = '<option value="">Выберите время</option>';

                    availableTimes.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = bookedTimes.includes(time) ? `${time} (занято)` : time;
                        option.disabled = bookedTimes.includes(time);
                        timeInput.appendChild(option);
                    });
                } catch (error) {
                    console.error('Ошибка:', error);
                    timeInput.innerHTML = '<option>Ошибка загрузки</option>';
                }
            }

            const genTimeSlots = () => {
                const slots = [];
                for (let hour = 9; hour < 20; hour++) {
                    if (hour === 13) continue;
                    for (let minute = 0; minute < 60; minute += 20) {
                        slots.push(`${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`);
                    }
                }
                return slots;
            }

            dateInput.addEventListener('change', loadAvailableTimes);
            setDate(); 
        });
    </script>
@endsection