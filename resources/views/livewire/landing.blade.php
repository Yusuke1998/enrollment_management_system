@extends('layouts.app_custom')

@section('title', 'Gestión de Academias y Cursos')
@section('description', 'Cursos y academias')

@section('content')
<!--Hero-->
<div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
  <!--Left Col-->
  <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left md:pl-8 lg:pl-12">
    <p class="uppercase tracking-loose w-full">Bienvenido a nuestro sistema</p>
    <h1 class="my-4 text-5xl font-bold leading-tight">
      Encuentra la mejor academia para tus hijos
    </h1>
    <p class="leading-normal text-2xl mb-8">
      Descubre una amplia variedad de cursos y academias diseñados para el desarrollo integral de tus hijos.
    </p>
  </div>
  <!--Right Col-->
  <div class="w-full md:w-3/5 py-6 text-center">
    <img class="w-full md:w-4/5 z-50" src='{{asset('images/zoom.png') }}' />
  </div>
</div>

<!--Academias y Cursos Section-->
<section class="bg-white py-8">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold mb-4">Nuestras Academias y Cursos</h2>
      <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
    </div>
    
    <!--Academias Grid-->
    <div class="mb-16">
      <div class="flex items-center mb-8">
        <h3 id="academias" class="text-3xl font-bold">Academias más populares</h3>
        <div class="flex-grow h-px bg-gray-300 ml-4"></div>
      </div>
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" id="academies-container">
        <!-- Academies will be dynamically inserted here -->
      </div>
      <div class="text-center mt-8" id="academias-load-more-container" style="display: none;">
        <button id="load-more-academies" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition duration-300">
          Ver más academias
        </button>
      </div>
    </div>

    <!--Cursos Destacados-->
    <div>
      <div class="flex items-center mb-8">
        <h3 id="cursos" class="text-3xl font-bold">Cursos Destacados</h3>
        <div class="flex-grow h-px bg-gray-300 ml-4"></div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="cursos-container">
        <!-- Los cursos se cargarán dinámicamente aquí -->
      </div>
      <div class="text-center mt-8" id="cursos-load-more-container" style="display: none;">
        <button id="load-more-courses" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition duration-300">
          Ver más cursos
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="bg-indigo-600 py-16">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-white mb-6">¿Listo para inscribir a tu hijo?</h2>
    <p class="text-xl text-indigo-100 mb-8 max-w-3xl mx-auto">
      Nuestro proceso de inscripción es sencillo y rápido. Selecciona la academia y el curso que mejor se adapte a las necesidades de tu hijo.
    </p>
    <!-- <a href="/enroll-form?cta=landing" class="inline-block bg-white text-indigo-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-indigo-50 transition duration-300">
      Inscribir Ahora
    </a> -->
    <button id="cta-enroll-form" class="inline-block bg-white text-indigo-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-indigo-50 transition duration-300">
    Inscribir Ahora
    </button>
  </div>
</section>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const addressTo = localStorage.getItem('addressTo');
    if (addressTo) {
      localStorage.removeItem('addressTo');
      window.location.href = addressTo;
    }
    
    // Variables para paginación
    let academiesPage = 1;
    let coursesPage = 1;
    let hasMoreAcademies = false;
    let hasMoreCourses = false;
    let isLoadingAcademies = false;
    let isLoadingCourses = false;

    // Function to truncate text
    function truncateText(text, maxLength = 100) {
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    }

    // Function to load academies
    async function loadAcademies(page = 1, append = false) {
      if (isLoadingAcademies) return;
      isLoadingAcademies = true;
      
      try {
        const response = await fetch(`/api/academies?page=${page}`);
        const data = await response.json();
        
        if (data.success) {
          const container = document.getElementById('academies-container');
          const loadMoreContainer = document.getElementById('academias-load-more-container');
          
          // Store if there are more academies
          hasMoreAcademies = data.has_more;
          
          // Show or hide load more button
          loadMoreContainer.style.display = hasMoreAcademies ? 'block' : 'none';
          
          // Create HTML for academies
          const academiesHTML = data.data.map(academy => `
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
              <div class="p-6">
                <h3 class="text-2xl font-bold mb-4">${academy.name}</h3>
                <p class="text-gray-600 mb-4 truncate-text" title="${academy.description}">${truncateText(academy.description)}</p>
                <div class="flex justify-between items-center">
                  <span class="text-indigo-600 font-semibold">${academy.courses?.length || 0} cursos disponibles</span>
                  <a href="/academy-details?id=${academy.id}" 
                      class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Explore
                  </a>
                </div>
              </div>
            </div>
          `).join('');
          
          // Append or replace content
          if (append) {
            container.innerHTML += academiesHTML;
          } else {
            container.innerHTML = academiesHTML;
          }
        }
      } catch (error) {
        console.error('Error loading academies:', error);
      } finally {
        isLoadingAcademies = false;
      }
    }

    // Function to load courses
    async function loadCourses(page = 1, append = false) {
      if (isLoadingCourses) return;
      isLoadingCourses = true;
      
      try {
        const response = await fetch(`/api/courses?page=${page}`);
        const data = await response.json();
        
        if (data.success) {
          const container = document.getElementById('cursos-container');
          const loadMoreContainer = document.getElementById('cursos-load-more-container');
          
          // Store if there are more courses
          hasMoreCourses = data.has_more;
          
          // Show or hide load more button
          loadMoreContainer.style.display = hasMoreCourses ? 'block' : 'none';
          
          // Create HTML for courses
          const coursesHTML = data.data.map(course => createCourseCard(course)).join('');
          
          // Append or replace content
          if (append) {
            container.innerHTML += coursesHTML;
          } else {
            container.innerHTML = coursesHTML;
          }
        }
      } catch (error) {
        console.error('Error loading courses:', error);
      } finally {
        isLoadingCourses = false;
      }
    }

    function createCourseCard(course) {
        return `
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">${course.name}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3" title="${course.description}">${truncateText(course.description)}</p>
                    <div class="flex justify-between text-sm text-gray-500 mb-4">
                        <span>${course.duration}</span>
                        <span>${course.modality}</span>
                        <span>$${course.cost}</span>
                    </div>
                    <a href="/course-details?id=${course.id}" class="mt-4 w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300 inline-block text-center">
                        Ver detalles
                    </a>
                </div>
            </div>
        `;
    }

    // Event listeners for load more buttons
    document.getElementById('load-more-academies').addEventListener('click', function() {
      if (hasMoreAcademies && !isLoadingAcademies) {
        academiesPage++;
        loadAcademies(academiesPage, true);
      }
    });
    
    document.getElementById('load-more-courses').addEventListener('click', function() {
      if (hasMoreCourses && !isLoadingCourses) {
        coursesPage++;
        loadCourses(coursesPage, true);
      }
    });

    document.getElementById('cta-enroll-form').addEventListener('click', function() {
      const path = '/enroll-form?cta=landing';
      if (!auth.redirectToLoginIfNotAuthenticated(path)) {
        return;
      }
      window.location.href = path;
    });

    // Load data when page loads
    loadAcademies();
    loadCourses();
  });
</script>
@endsection 

