@extends('layouts.app_custom')

@section('title', 'Detalles de Academia - Sistema de Gestión de Academias')
@section('description', 'Detalles de la academia y sus cursos disponibles')

@section('content')
<div class="container px-3 mx-auto">
  <!--Back Button-->
  <div class="mb-8">
    <a href="/" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
      Volver al inicio
    </a>
  </div>

  <!--Academy Header-->
  <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
    <div class="p-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-4" id="academy-name"></h1>
      <p class="text-lg text-gray-600" id="academy-description"></p>
    </div>
  </div>

  <!--Courses Section-->
  <div class="mb-16">
    <div class="flex items-center mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Cursos Disponibles</h2>
      <div class="flex-grow h-px bg-gray-300 ml-4"></div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="courses-container">
      <!-- Courses will be dynamically inserted here -->
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const academyId = urlParams.get('id');

    if (!academyId) {
      window.location.href = '/';
      return;
    }

    loadAcademyDetails(academyId);
  });

  function loadAcademyDetails(academyId) {
    fetch(`/api/academies/${academyId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          displayAcademyDetails(data.data.academy);
          displayCourses(data.data.courses);
        } else {
          console.error('Error loading academy details:', data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  function displayAcademyDetails(academy) {
    document.getElementById('academy-name').textContent = academy.name;
    document.getElementById('academy-description').textContent = academy.description || 'No description available';
  }

  function displayCourses(courses) {
    const container = document.getElementById('courses-container');
    container.innerHTML = '';

    courses.forEach(course => {
      const courseCard = document.createElement('div');
      courseCard.className = 'bg-white rounded-lg shadow-lg overflow-hidden';
      courseCard.innerHTML = `
        <div class="p-6">
          <h4 class="text-xl font-bold mb-2">${course.name}</h4>
          <p class="text-gray-600 mb-4 truncate-text" title="${course.description}">${course.description || 'No description available'}</p>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-gray-600">Duración:</span>
              <span class="font-semibold">${course.duration || 'Not specified'}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Modalidad:</span>
              <span class="font-semibold">${course.modality || 'Not specified'}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Costo:</span>
              <span class="font-semibold">$${course.cost || '0.00'}</span>
            </div>
          </div>
          <a href="/course-details?id=${course.id}" class="mt-4 w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300 inline-block text-center">
            Ver Detalles
          </a>
        </div>
      `;
      container.appendChild(courseCard);
    });
  }
</script>
@endsection 