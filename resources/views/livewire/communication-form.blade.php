<div>
    <x-slot name="header">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ $isEditing ? 'Editar Comunicación' : 'Nueva Comunicación' }}
        </h3>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form wire:submit.prevent="submit">
                <!-- Sección 1: Información básica del comunicado -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Comunicado</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Título -->
                        <div>
                            <x-label for="title" value="Título *" />
                            <x-input id="title" wire:model="title" type="text" class="mt-1 block w-full" required />
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Mensaje -->
                        <div>
                            <x-label for="message" value="Mensaje *" />
                            <textarea id="message" wire:model="message" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Criterios de filtrado -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Criterios de Filtrado (Opcional)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Filtro por curso -->
                        <div>
                            <x-label for="criteria_course_id" value="Curso" />
                            <select id="criteria_course_id" wire:model="criteria_course_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los cursos</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Filtro por edad mínima -->
                        <div>
                            <x-label for="criteria_min_age" value="Edad mínima (hijos)" />
                            <x-input id="criteria_min_age" wire:model="criteria_min_age" type="number" min="0" class="mt-1 block w-full" />
                        </div>
                        
                        <!-- Filtro por edad máxima -->
                        <div>
                            <x-label for="criteria_max_age" value="Edad máxima (hijos)" />
                            <x-input id="criteria_max_age" wire:model="criteria_max_age" type="number" min="0" class="mt-1 block w-full" />
                            @error('criteria_max_age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Selección manual de padres -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Selección de Destinatarios</h3>
                    
                    <div class="mb-4">
                        <div class="flex items-center">
                            <x-input id="search_father" wire:model="searchTerm" wire:keydown.enter="searchFathers" type="text" class="block w-full" placeholder="Buscar padres..." />
                            <button type="button" wire:click="searchFathers" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Buscar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Resultados de búsqueda y selección -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Lista de padres disponibles -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-700 mb-3">Padres disponibles</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($availableFathers as $father)
                                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                                        <div>
                                            <p class="font-medium">{{ $father->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $father->email }}</p>
                                        </div>
                                        <button type="button" wire:click="addFather({{ $father->id }})" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No se encontraron resultados</p>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Lista de padres seleccionados -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-700 mb-3">Padres seleccionados</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($this->selectedFathersDetails as $father)
                                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                                        <div>
                                            <p class="font-medium">{{ $father->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $father->email }}</p>
                                        </div>
                                        <button type="button" wire:click="removeFather({{ $father->id }})" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No hay padres seleccionados</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Previsualización de destinatarios -->
                <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Resumen de Destinatarios</h3>
                    <p class="text-gray-600">{{ $this->recipientsSummary }}</p>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <x-button type="button" class="bg-gray-600 hover:bg-gray-700" onclick="window.location='{{ route('communications.index') }}'">
                        Cancelar
                    </x-button>
                    <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                        {{ $isEditing ? 'Actualizar Comunicación' : 'Guardar y Enviar' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>