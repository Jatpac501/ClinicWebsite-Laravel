<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Добавить врача
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700">Выберите пользователя</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="speciality_id" class="block text-gray-700">Выберите специальность</label>
                        <select name="speciality_id" id="speciality_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                        @error('speciality_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="experience" class="block text-gray-700">Опыт (лет)</label>
                        <input type="number" name="experience" id="experience" value="{{ old('experience') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('experience')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="about" class="block text-gray-700">О враче (описание)</label>
                        <textarea name="about" id="about" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('about') }}</textarea>
                        @error('about')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                            Добавить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
