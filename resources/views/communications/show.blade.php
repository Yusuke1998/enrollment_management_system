<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de Comunicación #{{ $communication->id }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Botones de acción -->
            <div class="flex justify-between mb-8">
                <a href="{{ route('communications.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
                <div class="space-x-2">
                    <a href="{{ route('communications.edit', $communication->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Editar
                    </a>
                    <form action="{{ route('communications.resend', $communication->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                                onclick="return confirm('¿Estás seguro de querer reenviar esta comunicación a todos los destinatarios originales?')">
                            Reenviar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Información General</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">Título:</span> {{ $communication->title }}</p>
                        <p><span class="font-medium">Fecha de envío:</span> {{ $communication->sent_date->format('d/m/Y H:i') }}</p>
                        @if($communication->course)
                            <p><span class="font-medium">Curso filtrado:</span> {{ $communication->course->name }}</p>
                        @else
                            <p><span class="font-medium">Curso filtrado:</span> Todos los cursos</p>
                        @endif
                        @if($communication->criteria_min_age || $communication->criteria_max_age)
                            <p><span class="font-medium">Rango de edad:</span> 
                                {{ $communication->criteria_min_age ? $communication->criteria_min_age.' años' : 'Sin mínimo' }} - 
                                {{ $communication->criteria_max_age ? $communication->criteria_max_age.' años' : 'Sin máximo' }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Estadísticas</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">Total destinatarios:</span> {{ $communication->recipients->count() }}</p>
                        <p><span class="font-medium">Entregados:</span> {{ $communication->recipients->where('status', \App\Models\Communication::SENT)->count() }}</p>
                        <p><span class="font-medium">Pendientes:</span> {{ $communication->recipients->where('status', \App\Models\Communication::PENDING)->count() }}</p>
                        <p><span class="font-medium">Fallidos:</span> {{ $communication->recipients->where('status', \App\Models\Communication::FAILED)->count() }}</p>
                        <p><span class="font-medium">Reenviados:</span> {{ $communication->recipients->where('is_resent', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Mensaje</h3>
                <div class="whitespace-pre-line">{{ $communication->message }}</div>
            </div>

            <!-- Lista de destinatarios -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Destinatarios</h3>
                
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reenviado
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($communication->recipients as $recipient)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $recipient->recipient->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $recipient->recipient->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $recipient->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                           ($recipient->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $recipient->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $recipient->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($recipient->is_resent)
                                        <span class="text-indigo-600">SI</span>
                                    @else
                                        <span class="text-gray-600">NO</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>