@extends('layouts.app')

@section('title', 'Registro - Sistema de Gestión de Academias')
@section('description', 'Regístrate para inscribir a tus hijos en nuestros cursos')

@section('content')
<div class="container px-3 mx-auto">
  <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-8">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Crear una cuenta</h2>
      
      <form wire:submit.prevent="register">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre completo</label>
          <input wire:model="name" type="text" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" placeholder="Tu nombre completo">
          @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electrónico</label>
          <input wire:model="email" type="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" placeholder="tu@email.com">
          @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
          <input wire:model="password" type="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" placeholder="********">
          @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-6">
          <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar contraseña</label>
          <input wire:model="password_confirmation" type="password" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="********">
        </div>
        
        <div class="flex items-center justify-between">
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
            Registrarse
          </button>
        </div>
      </form>
      
      <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
          ¿Ya tienes una cuenta? 
          <a href="{{ route('login', ['redirect' => $redirectUrl]) }}" class="text-indigo-600 hover:text-indigo-800">Inicia sesión</a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection 