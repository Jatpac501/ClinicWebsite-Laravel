<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Управление врачами
            </h2>
            <a href="{{ route('admin.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                Добавить врача
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Имя</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Опыт</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($doctors as $doctor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->experience }} лет</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.edit', ["id" => $doctor->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('admin.destroy', $doctor) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <input id="doctor_id" name="doctor_id" value="{{ $doctor->id }}" type="hidden" readonly />
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2"
                                            onclick="return confirm('Вы уверены, что хотите удалить врача?')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-600">
                                    Нет врачей для отображения.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
