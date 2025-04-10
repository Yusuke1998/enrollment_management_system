@extends('layouts.app')

@section('title', 'Iniciar Sesión')
@section('description', 'Inicia sesión en tu cuenta para acceder a todas las funcionalidades.')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Iniciar Sesión</h2>

        {{-- <form wire:submit.prevent="login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" wire:model="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required autofocus>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" wire:model="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Recordarme</label>
                </div>

                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Iniciar Sesión
                </button>
            </div>
        </form> --}}

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</div>
@endsection 