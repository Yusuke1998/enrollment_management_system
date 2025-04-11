<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- <x-welcome /> -->
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        {{ __('¡Bienvenido al sistema de gestión!') }}
                    </div>

                    <div class="mt-6 text-gray-500">
                        {{ __('Aquí podrás gestionar tus comunicaciones y mucho más.') }}
                    </div>
                    <div class="mt-6 text-gray-500">
                        {{ __('Utiliza el menú de navegación para acceder a las diferentes secciones del sistema.') }}
                    </div>
                    <div class="mt-6 text-gray-500">
                        {{ __('Si tienes alguna duda, no dudes en contactar con el soporte.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
