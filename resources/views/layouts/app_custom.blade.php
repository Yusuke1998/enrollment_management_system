<!DOCTYPE html>
<html lang="es">
    <head>
        @livewireStyles
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>@yield('title', 'Sistema de Gestión de Academias')</title>
        <meta name="description" content="@yield('description', 'Sistema de gestión para academias y cursos')" />
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
        @yield('styles')
    </head>
    <body class="leading-normal tracking-normal text-gray-800" style="font-family: 'Source Sans Pro', sans-serif;">
        <!--Nav-->
        <nav id="header" class="fixed w-full z-30 top-0 text-white">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
                <div class="pl-4 flex items-center">
                    <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="/">
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
                            <a class="inline-block py-2 px-4 text-black font-bold no-underline" href="/">Inicio</a>
                        </li>
                        <li class="mr-3">
                            <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="/#academias">Academias</a>
                        </li>
                        <li class="mr-3">
                            <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="/#cursos">Cursos</a>
                        </li>
                        <!-- Authentication -->
                        @auth
                        <li class="mr-3">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();"
                                    onclick="localStorage.removeItem('auth_token');">
                                    Logout
                                </a>
                            </form>
                        </li>
                        @else
                        <li class="mr-3">
                            <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="{{ route('login') }}">Login</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!--Main Content-->
        <div class="pt-24">
            @yield('content')
        </div>

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
                            <li class="mb-2"><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li class="mb-2"><a href="/#academias" class="text-gray-400 hover:text-white">Academias</a></li>
                            <li class="mb-2"><a href="/#cursos" class="text-gray-400 hover:text-white">Cursos</a></li>
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
        <script src="{{ asset('js/auth.js') }}"></script>
        @yield('scripts')
    </body>
</html>
