@extends('layouts.app_custom')

@section('title', 'Formulario de Inscripción - Sistema de Gestión de Academias')
@section('description', 'Complete el formulario para inscribir a su hijo en el curso seleccionado')

@section('content')
<div class="container px-3 mx-auto">
  <!--Back Button-->
  <div class="mb-8">
    <a href="javascript:history.back()" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
      Volver
    </a>
  </div>

  <!--Enrollment Form-->
  <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
    <div class="p-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Formulario de Inscripción</h1>
      
      <div class="mb-6">
        <p class="text-lg text-gray-600">Complete el formulario para inscribir a su hijo en el curso seleccionado.</p>
      </div>
      
      <form id="enrollment-form" class="space-y-6">
        <input type="hidden" id="course-id" name="course_id">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Student Information -->
          <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Información del Estudiante</h2>
            
            <div>
              <label for="student-name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
              <input type="text" id="student-name" name="student_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            
            <div>
              <label for="student-birthdate" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
              <input type="date" id="student-birthdate" name="student_birthdate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            
            <div>
              <label for="student-email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
              <input type="email" id="student-email" name="student_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
          </div>
          
          <!-- Parent/Guardian Information -->
          <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Información del Padre/Tutor</h2>
            
            <div>
              <label for="parent-name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
              <input type="text" id="parent-name" name="parent_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            
            <div>
              <label for="parent-email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
              <input type="email" id="parent-email" name="parent_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            
            <div>
              <label for="parent-phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
              <input type="tel" id="parent-phone" name="parent_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
          </div>
        </div>
        
        <div class="pt-4">
          <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 text-lg font-medium">
            Enviar Inscripción
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check if user is authenticated
    if (!auth.redirectToLoginIfNotAuthenticated()) {
      return;
    }
    
    // Get course ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get('course_id');
    
    if (!courseId) {
      window.location.href = '/';
      return;
    }
    
    // Set course ID in hidden input
    document.getElementById('course-id').value = courseId;
    
    // Load course details
    loadCourseDetails(courseId);
    
    // Handle form submission
    document.getElementById('enrollment-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Get form data
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());
      
      // Get token
      const token = auth.getToken();
      
      // Submit enrollment
      fetch('/api/enrollments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al enviar la inscripción');
        }
        return response.json();
      })
      .then(data => {
        alert('Inscripción enviada con éxito');
        window.location.href = '/';
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la inscripción. Por favor, intente nuevamente.');
      });
    });
  });
  
  function loadCourseDetails(courseId) {
    fetch(`/api/courses/${courseId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // You can display course details here if needed
          console.log('Course details loaded:', data.data.course);
        } else {
          console.error('Error loading course details:', data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
</script>
@endsection 