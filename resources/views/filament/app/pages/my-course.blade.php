<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ __('Meus Cursos') }}
        </h1>
    </x-slot>

    <div class="mt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($myCourses as $course)
                <x-filament::card class="bg-white dark:bg-gray-800 shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <img src="https://placehold.co/400x200" alt="{{ $course->title }}" class="w-16 h-16 rounded-md object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $course->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $course->description}}</p>
                            </div>

                            <x-filament::button href="" class="ml-4 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                                {{ __('Ver') }}
                            </x-filament::button>
                        </div>
                    </div>

                </x-filament::card>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
