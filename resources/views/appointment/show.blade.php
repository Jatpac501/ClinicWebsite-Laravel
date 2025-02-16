<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Запись №{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 space-y-8">
                <!-- Информация о записи -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Секция с основной информацией -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Дата и время</h3>
                            <p class="mt-2 text-gray-600">
                                {{ $appointment->date }} в {{ $appointment->time }}
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Статус</h3>
                            <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($appointment->status == 'Завершено') bg-green-100 text-green-800 
                                @elseif($appointment->status == 'Отменено') bg-red-100 text-red-800 
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ $appointment->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Секция с информацией о докторе и пациенте -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Доктор</h3>
                            <div class="mt-2 text-gray-600">
                                <p class="font-medium">{{ $appointment->doctor->user->name }}</p>
                                <p>{{ $appointment->doctor->speciality->name }}</p>
                                <p class="text-sm text-gray-500">Опыт: {{ $appointment->doctor->experience }} лет</p>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Пациент</h3>
                            <p class="mt-2 text-gray-600">{{ $appointment->user->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Блок управления статусом -->
                @if($appointment->status == 'Запланировано')
                    <div class="mt-8 border-t pt-6 flex gap-4">
                        @if(Auth::user()->role === 'doctor')
                            <form method="POST" action="{{ route('appointments.complete', $appointment->id) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-500">
                                    Завершить приём
                                </button>
                            </form>
                            <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-500">
                                    Отменить приём
                                </button>
                            </form>
                        @elseif(Auth::user()->role === 'patient')
                            <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-500">
                                    Отменить приём
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <!-- Блок с выпиской -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Медицинская выписка</h3>
                    @if($appointment->file_path)
                        <a href="{{ asset('storage/'.$appointment->file_path) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800"
                           download>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Скачать выписку
                        </a>
                    @else
                        <p class="text-gray-500">Выписка не загружена</p>
                    @endif
                </div>

                <!-- Форма загрузки файла для доктора -->
                @if(Auth::user()->role === 'doctor')
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Загрузить выписку</h3>
                        <form action="{{ route('appointments.uploadFile', [Auth::user()->id, $appointment->id]) }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="flex items-center gap-4">
                            @csrf
                            <div class="flex-1">
                                <input type="file" 
                                       name="file" 
                                       id="file" 
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none"
                                       accept=".pdf" 
                                       required>
                            </div>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-500">
                                Загрузить
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>