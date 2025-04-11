<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Comunicación') }}
        </h2>
    </x-slot>

    @livewire('communication-form', ['communicationId' => $communication->id], key($communication->id))
</x-app-layout>