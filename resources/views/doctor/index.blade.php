<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Результаты поиска врачей') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($doctors->isEmpty())
                <div class="text-center text-gray-600">
                    <p class="text-lg font-medium">По вашему запросу ничего не найдено.</p>
                    <p class="text-sm text-gray-500 mt-2">Попробуйте изменить параметры поиска.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($doctors as $doctor)
                        <a 
                            href="{{ route('doctor.index', $doctor) }}" 
                            class="block bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden"
                        >
                            <div class="p-4 text-center">
                                <div class="mb-4">
                                    <img 
                                        src="{{ $doctor->user->avatar ?? asset('default-avatar.webp') }}" 
                                        alt="{{ $doctor->user->name }} Avatar" 
                                        class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-primary-500"
                                    >
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $doctor->user->name }}</h3>
                                <p class="text-sm text-gray-600 mt-2">
                                    {{ $doctor->speciality->name ?? 'Специальность не указана' }} | 
                                    Стаж {{ $doctor->experience }} лет
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>