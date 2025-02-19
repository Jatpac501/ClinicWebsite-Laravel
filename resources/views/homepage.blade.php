<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">

        <div class="text-center mb-8">
            <x-application-logo class="w-96 fill-current text-gray-500" />
            <p class="text-gray-600 mt-2">Ваш надежный партнер в заботе о здоровье</p>
        </div>

        <div class="w-full max-w-md mb-8">
            <form action="{{ route('search') }}" method="GET" class="flex items-center space-x-4">
                <x-text-input 
                    type="text" 
                    name="query" 
                    placeholder="Поиск врача или специальности..." 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                />
                <x-primary-button 
                    type="submit" 
                    class="px-4 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors"
                    aria-label="Поиск"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </x-primary-button>
            </form>
        </div>

    </div>
</x-app-layout>
