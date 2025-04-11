@extends('layouts.app_custom')

@section('title', 'Confirmación de Inscripción')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h1 class="text-2xl font-bold text-gray-800 mt-4">¡Inscripción Exitosa!</h1>
            <p class="text-gray-600 mt-2">Hemos recibido tu solicitud de inscripción correctamente.</p>
            <span class="font-medium">{{ $enrollment->created_at->diffForHumans() }}</span>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-lg font-medium text-gray-900">Resumen de tu inscripción</h2>
            <div class="mt-4 space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Código de inscripción:</span>
                    <span class="font-medium">{{ $enrollment->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Estudiante:</span>
                    <span class="font-medium">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Curso:</span>
                    <span class="font-medium">{{ $enrollment->course->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Academia:</span>
                    <span class="font-medium">{{ $enrollment->course->academy->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Fecha:</span>
                    <span class="font-medium">{{ $enrollment->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-6">
            <p class="text-gray-600">Te hemos enviado un correo electrónico a <span class="font-medium">{{ $enrollment->email }}</span> con los detalles de tu inscripción.</p>
            <p class="text-gray-600 mt-2">Si tienes alguna pregunta, no dudes en contactarnos.</p>
            
            <div class="mt-6">
                <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection