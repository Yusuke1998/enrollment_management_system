<!DOCTYPE html>
<html lang="es">
  <head>
    @livewireStyles
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sistema de Gestión de Academias</title>
    <meta name="description" content="Sistema de gestión de academias y cursos" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <style>
      .gradient {
        background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
      }
      .truncate-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 4.5em;
      }
    </style>
  </head>
  <body class="leading-normal tracking-normal text-gray-800" style="font-family: 'Source Sans Pro', sans-serif;">
    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
      <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
        <div class="pl-4 flex items-center">
          <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
            <img src="{{asset('storage/logo.png') }}" alt="Logo" class="h-12 md:h-16 lg:h-20 w-auto">
          </a>
        </div>
        <div class="block lg:hidden pr-4">
          <button id="nav-toggle" class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <title>Menu</title>
              <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
          </button>
        </div>
        <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20" id="nav-content">
          <ul class="list-reset lg:flex justify-end flex-1 items-center">
            <li class="mr-3">
              <a class="inline-block py-2 px-4 text-black font-bold no-underline" href="#">Inicio</a>
            </li>
            <li class="mr-3">
              <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="#academias">Academias</a>
            </li>
            <li class="mr-3">
              <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="#cursos">Cursos</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!--Hero-->
    <div class="pt-24">
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
          <img class="w-full md:w-4/5 z-50" src='{{asset('storage/zoom.png') }}' />
        </div>
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

    <!--Footer-->
    <footer class="bg-gray-800 text-white py-8">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-between">
          <div class="w-full md:w-1/3 mb-8 md:mb-0">
            <h4 class="text-xl font-bold mb-4">Sistema de Gestión</h4>
            <p class="text-gray-400">Brindando la mejor educación para tus hijos.</p>
          </div>
          <div class="w-full md:w-1/3 mb-8 md:mb-0">
            <h4 class="text-xl font-bold mb-4">Enlaces Rápidos</h4>
            <ul class="list-reset">
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white">Inicio</a></li>
              <li class="mb-2"><a href="#academias" class="text-gray-400 hover:text-white">Academias</a></li>
              <li class="mb-2"><a href="#cursos" class="text-gray-400 hover:text-white">Cursos</a></li>
            </ul>
          </div>
          <div class="w-full md:w-1/3">
            <h4 class="text-xl font-bold mb-4">Contacto</h4>
            <p class="text-gray-400">Email: jhonnyjose1998@gmail.com</p>
            <p class="text-gray-400">Teléfono: +58 4122796352</p>
          </div>
        </div>
        <div class="text-center mt-8 pt-8 border-t border-gray-700">
          <p class="text-gray-400">&copy; 2025 Sistema de Gestión. Todos los derechos reservados.</p>
        </div>
      </div>
    </footer>

    @livewireScripts
    <script>
      document.addEventListener('DOMContentLoaded', function() {
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

        // Load data when page loads
        loadAcademies();
        loadCourses();
      });
    </script>
  </body>
</html>