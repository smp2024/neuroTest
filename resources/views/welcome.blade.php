<!DOCTYPE html>
<!--html-->
    <html lang="es">
        <!--head-->
            <head>

                <!--metas-->
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <meta name="routeName" content="{{ Route::currentRouteName() }}">

                <!--icon-->
                    <link rel="icon" type="image/png" href="{{ url('favicon.ico') }}" />

                <!--title-->

                    <title> @yield('title')</title>

                <!--CSS-->
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
                    @yield('css')

                    <style>
                        .pnav_ {
                            font-size: calc(0.5rem + 0.5vw) !important;
                        }
                        @media (max-width: 575px) and (orientation:portrait) {
                            .pnav_ {
                                font-size: calc(0.7rem + 0.4vw) !important;
                            }
                        }
                    </style>

            </head>
        <!--body-->
            <body>

                <!--Navbar-->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                        <a class="navbar-brand" href="{{ url('/') }}">Servicios Neurológicos</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav w-100 d-flex justify-content-end">
                            @auth

                               {{-- <li class="nav-item {{ Route::currentRouteName() == 'respuestas.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/respuestas') }}">Respuestas <span class="sr-only">(current)</span></a>
                                </li> --}}
                                <li class="nav-item {{ Route::currentRouteName() == 'projects.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/projects') }}">Proyectos<span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'forms.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/forms') }}">Formularios <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'patients.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/patients') }}">Pacientes <span class="sr-only">(current)</span></a>
                                </li>

                                <li class="nav-item  link-user dropdow ">
                                    <a href="#" class="nav-link   dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Hola: {{ Auth::user()->name }} </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a href="{{ url('/profile') }}" class="nav-link " data-toggle="tooltip" data-placement="top" title="Perfil">
                                                <i class="fas fa-power-off">
                                                    Perfil de Usuario
                                                </i>
                                            </a>
                                            <a href="{{ url('/logout') }}" class="nav-link " data-toggle="tooltip" data-placement="top" title="Salir">
                                                <i class="fas fa-power-off">
                                                    Cerrar sesión
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item {{ Route::currentRouteName() == 'login' ? 'active' : '' }} ">
                                    <a class="nav-link" href="{{ url('/login') }}">Login <span class="sr-only">(current)</span></a>
                                </li>
                            @endauth
                            </ul>

                        </div>
                    </nav>
                <!--Alert errors-->
                    @if (Session::has('message'))
                        <div class="container mt-2">
                            <div class="alert alert-{{ Session::get('typealert') }}" style="display: none;">
                                {{ Session::get('message') }}
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                <!--Content-->
                <div class=""  >
                    @yield('content')
                </div>

                <!--Script-->
                    <script src="{{ asset('js/jquery.js') }}"></script>
                    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
                    <script src="{{ asset('js/utils.js') }}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="{{ asset('js/site.js') }}"></script>


                <!--individual-Script-page-->
                    @yield('scripts')

            </body>
    </html>

