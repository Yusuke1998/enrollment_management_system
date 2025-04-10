@extends('layouts.app_custom')

@section('title', 'Detalles de Curso - Sistema de Gestión de Academias')
@section('description', 'Información detallada del curso seleccionado')

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

  <!--Course Header-->
  <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
    <div class="p-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-4" id="course-name"></h1>
      <p class="text-lg text-gray-600 mb-6" id="course-description"></p>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-500">Duración</h3>
          <p class="mt-1 text-lg font-semibold text-gray-900" id="course-duration"></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-500">Modalidad</h3>
          <p class="mt-1 text-lg font-semibold text-gray-900" id="course-modality"></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-500">Costo</h3>
          <p class="mt-1 text-lg font-semibold text-gray-900" id="course-cost"></p>
        </div>
      </div>
    </div>
  </div>

  <!--Academy Info-->
  <div class="mb-16">
    <div class="flex items-center mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Academia</h2>
      <div class="flex-grow h-px bg-gray-300 ml-4"></div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg overflow-hidden" id="academy-container">
      <!-- Academy info will be dynamically inserted here -->
    </div>
  </div>

  <!--Enrollment Section-->
  <div class="mb-16">
    <div class="flex items-center mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Inscripción</h2>
      <div class="flex-grow h-px bg-gray-300 ml-4"></div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg overflow-hidden p-8">
      <p class="text-lg text-gray-600 mb-6">Complete el formulario para inscribir a su hijo en este curso.</p>
      
      <button id="enroll-button" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 text-lg font-medium">
        Inscribir Ahora
      </button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get('id');

    if (!courseId) {
      window.location.href = '/';
      return;
    }

    loadCourseDetails(courseId);
  });

  function loadCourseDetails(courseId) {
    fetch(`/api/courses/${courseId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          displayCourseDetails(data.data.course);
          displayAcademyInfo(data.data.academy);
        } else {
          console.error('Error loading course details:', data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  function displayCourseDetails(course) {
    document.getElementById('course-name').textContent = course.name;
    document.getElementById('course-description').textContent = course.description || 'No description available';
    document.getElementById('course-duration').textContent = course.duration || 'Not specified';
    document.getElementById('course-modality').textContent = course.modality || 'Not specified';
    document.getElementById('course-cost').textContent = `$${course.cost || '0.00'}`;
  }

  function displayAcademyInfo(academy) {
    const container = document.getElementById('academy-container');
    container.innerHTML = `
      <div class="p-6">
        <h3 class="text-xl font-bold mb-2">${academy.name}</h3>
        <p class="text-gray-600 mb-4">${academy.description || 'No description available'}</p>
        <a href="/academy-details?id=${academy.id}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
          Ver más detalles de la academia
          <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    `;
  }

  document.getElementById('enroll-button').addEventListener('click', function() {
    // Aquí se implementará la lógica de inscripción
    alert('Funcionalidad de inscripción en desarrollo');
  });
</script>
@endsection 