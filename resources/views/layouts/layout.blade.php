<!doctype html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
{{--     <link href="{{ asset(mix('css/backend.css')) }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name') }} - @yield('page-title','Panel de Administración')</title>

    
</head>

<body class="{{ str_replace('.',' ',request()->route()->getName()) }}">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="">
                        <img src="{{ asset('img/logotipo-header-blanco.png') }}" alt="Admin">
                    </a>
                    <a class="nav-toggler d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav float-start me-auto">
                    </ul>
                    
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted pro-pic" href="" id="navbarDropdown" data-bs-toggle="dropdown">
                                <i class="mdi mdi-account-circle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i>
                                    Mis Datos Personales
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            
            <aside class="left-sidebar">
                <div class="scroll-sidebar">
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
{{--                             <li>
                                <div class="user-profile d-flex no-block dropdown m-t-20">
                                    <div class="user-content hide-menu m-l-10">
                                        <a href="#" class="" id="Userdd" data-bs-toggle="dropdown">
                                            <h5 class="m-b-0 user-name font-medium">@if (Auth::check()){{Auth::user()->nombre}} {{Auth::user()->primer_apellido}} {{Auth::user()->segundo_apellido}} @else Usuario @endif <i class="fa fa-angle-down"></i></h5>
                                            <span class="op-5 user-email">@if (Auth::check()){{Auth::user()->email}} @else correo @endif</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="Userdd">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> Mis Datos Personales</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route('backend.logout')}}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar Sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="">
                                    <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Panel de Control</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="">
                                    <i class="mdi mdi-star-box-multiple"></i><span class="hide-menu">Servicios</span>
                                </a>
                            </li>

                            @role('administrador')
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow" href="#">
                                        <i class="mdi mdi-database"></i><span class="hide-menu">Datos Maestros</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse first-level">
                                        <li class="sidebar-item">
                                            <a href="" class="sidebar-link"><i class="fas fa-list"></i><span class="hide-menu"> Marcas</span></a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="" class="sidebar-link"><i class="fas fa-list"></i><span class="hide-menu"> Modelos</span></a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="page-wrapper">
                <div class="page-breadcrumb">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <h4 class="page-title">@yield('page-title','')</h4>
                            <div class="d-flex align-items-center">
                                <nav>
                                    @yield('breadcrumb')
                                </nav>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="text-end">
                                @yield('call-to-action')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    @yield('content')
                </div>
                <footer class="footer text-center">
                    {{ config('app.name') }}
                </footer>
            </div>
        </div>
        
        
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


      
        @stack('javascript')
        
    </body>
    
    </html>