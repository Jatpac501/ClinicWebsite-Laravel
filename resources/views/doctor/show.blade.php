<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $doctor->speciality->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <p class="text-lg font-semibold text-gray-900">{{ $doctor->user->name }}</p>
                <p class="text-gray-600">Стаж: {{ $doctor->experience }} лет</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-primary-600 mb-4">Запись к врачу</h2>
                <form method="POST" action="{{ route('appointments.store', $doctor->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="date" value="Выберите день:" />
                        <x-text-input 
                            id="date" 
                            type="date" 
                            name="date" 
                            min="{{ now()->addDays(1)->toDateString() }}" 
                            max="{{ now()->addDays(7)->toDateString() }}" 
                            required 
                            autofocus 
                            class="mt-1 block w-full"
                        />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="time" value="Выберите время:" />
                        <select 
                            id="time" 
                            name="time" 
                            required 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        >
                            <option value="" disabled selected>Выберите время</option>
                        </select>
                        <x-input-error :messages="$errors->get('time')" class="mt-2" />
                    </div>
                    @auth
                    <div>
                        <x-primary-button>
                            Записаться
                        </x-primary-button>
                    </div>
                    @endauth
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('date');
            const timeInput = document.getElementById('time');

            const genTimeSlots = () => {
                const slots = [];
                for (let hour = 9; hour < 20; hour++) {
                    if (hour === 13) continue;
                    for (let minute = 0; minute < 60; minute += 20) {
                        slots.push(`${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`);
                    }
                }
                return slots;
            };

            const isWeekend = (date) => {
                const day = new Date(date).getDay();
                return day === 0 || day === 6;
            };

            const loadAvailableTimes = async () => {
                timeInput.innerHTML = '<option disabled>Загрузка...</option>';
                try {
                    const response = await fetch(`/doctor/{{ $doctor->id }}/appointments/booked-times?date=${dateInput.value}`);
                    if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
                    const bookedTimes = await response.json();

                    const availableTimes = genTimeSlots();
                    timeInput.innerHTML = '<option value="" disabled selected>Выберите время</option>';

                    availableTimes.forEach((time) => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = bookedTimes.includes(time) ? `${time} (занято)` : time;
                        option.disabled = bookedTimes.includes(time);
                        timeInput.appendChild(option);
                    });
                } catch (error) {
                    console.error('Ошибка:', error);
                    timeInput.innerHTML = '<option disabled>Ошибка загрузки</option>';
                }
            };

            
            dateInput.addEventListener('change', () => {
                if (isWeekend(dateInput.value)) {
                    timeInput.innerHTML = '<option disabled>Выходной день</option>';
                } else {
                    loadAvailableTimes();
                }
            });

            dateInput.min = '{{ now()->addDays(1)->toDateString() }}';
            dateInput.max = '{{ now()->addDays(7)->toDateString() }}';
            dateInput.value = '';
        });
    </script>
</x-app-layout>