<div class="container px-3 mx-auto">
  <!-- Back Button -->
  <div class="mb-8">
    <a href="javascript:history.back()" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
      Volver
    </a>
  </div>

  <!-- Progress Bar -->
  <div class="max-w-2xl mx-auto mb-8">
    <div class="flex justify-between mb-2">
      @for($i = 1; $i <= $totalSteps; $i++)
        <div class="text-center">
          <span class="block text-sm font-medium @if($i <= $currentStep) text-indigo-600 @else text-gray-500 @endif">
            Paso {{ $i }}
          </span>
        </div>
      @endfor
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
      <div class="bg-indigo-600 h-2.5 rounded-full" 
           style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
    </div>
  </div>

  <!-- Form Container -->
  <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    @if (session()->has('message'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
          {{ session('message') }}
      </div>
    @endif

    <!-- Paso 1: Seleccionar academia y curso -->
    @if($currentStep === 1)
      <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-800">Selecciona Academia y Curso</h2>
        
        <div>
          <label for="academy" class="block text-sm font-medium text-gray-700">Academia</label>
          <select id="academy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                  wire:model.lazy="academy">
            <option value="">Selecciona una academia</option>
            @foreach($academies as $academy)
              <option value="{{ $academy->id }}">{{ $academy->name }}</option>
            @endforeach
          </select>
          @error('academy') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="course" class="block text-sm font-medium text-gray-700">Curso</label>
          <select id="course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                  wire:model.lazy="course" {{ !$academy ? 'disabled' : '' }}>
            @if(!$academy)
              <option>Primero selecciona una academia</option>
            @elseif($courses->isEmpty())
              <option>No hay cursos disponibles para esta academia</option>
            @endif
            @foreach($courses as $course)
              <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
          </select>
          @error('course') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
          <button type="button" wire:click="nextStep" 
                  class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Siguiente
          </button>
        </div>
      </div>
    @endif

    <!-- Paso 2: Datos del estudiante -->
    @if($currentStep === 2)
      <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-800">Datos del Estudiante</h2>
        
        <div>
          <label for="first_name" class="block text-sm font-medium text-gray-700">Nombres</label>
          <input type="text" wire:model="first_name" id="first_name" 
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
          <input type="text" wire:model="last_name" id="last_name" 
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="birth_date" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
          <input type="date" wire:model="birth_date" id="birth_date" 
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
          <input type="email" wire:model="email" id="email" 
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
          <input type="tel" wire:model="phone" id="phone" 
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-between">
          <button type="button" wire:click="prevStep" 
                  class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Anterior
          </button>
          <button type="button" wire:click="nextStep" 
                  class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Siguiente
          </button>
        </div>
      </div>
    @endif

    <!-- Paso 3: Datos de pago -->
    @if($currentStep === 3)
      <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-800">Información de Pago</h2>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Método de Pago</label>
          <div class="mt-1 space-y-2">
            <div class="flex items-center">
              <input id="cash" wire:model="paymentMethod" type="radio" value="efectivo" 
                     class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
              <label for="cash" class="ml-2 block text-sm text-gray-700">Efectivo</label>
            </div>
            <div class="flex items-center">
              <input id="transfer" wire:model="paymentMethod" type="radio" value="transferencia" 
                     class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
              <label for="transfer" class="ml-2 block text-sm text-gray-700">Transferencia Bancaria</label>
            </div>
            <div class="flex items-center">
              <input id="credit-card" wire:model="paymentMethod" type="radio" value="tarjeta" 
                     class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
              <label for="credit-card" class="ml-2 block text-sm text-gray-700">Tarjeta de Crédito/Débito</label>
            </div>
            @error('paymentMethod') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
          </div>
        </div>

        @if($paymentMethod === 'card')
          <div class="space-y-4">
            <div>
              <label for="cardNumber" class="block text-sm font-medium text-gray-700">Número de Tarjeta</label>
              <input type="text" wire:model="cardNumber" id="cardNumber" 
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                     placeholder="1234 5678 9012 3456">
              @error('cardNumber') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="expiryDate" class="block text-sm font-medium text-gray-700">Fecha de Expiración</label>
                <input type="text" wire:model="expiryDate" id="expiryDate" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="MM/AA">
                @error('expiryDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <div>
                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                <input type="text" wire:model="cvv" id="cvv" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="123">
                @error('cvv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
        @endif

        <div class="flex justify-between">
          <button type="button" wire:click="prevStep" 
                  class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Anterior
          </button>
          <button type="button" wire:click="submit" 
                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Completar Inscripción
          </button>
        </div>
      </div>
    @endif
  </div>
</div>