<!DOCTYPE html>
<html class="loading" lang="es">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Femec</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="css/plantilla.css" rel="stylesheet">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <div id="app">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" ><i class="ficon feather icon-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li> -->

                        <!-- Aqui van las cosas por cambiar en el logiout y todo eso -->
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link"  data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600">{{Auth::user()->usuario}}</span>
                                    <span class="user-status">Activo</span>
                                </div>
                                <span>
                                    <img class="round" src="images/perfil.jpg" alt="avatar" height="40" width="40">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i i class="feather icon-power"></i> Logout
                                </a>
                                <form action="{{route('logout')}}" method="POST" id="logout-form" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    @if(Auth::check())
        @if (Auth::user()->idroles==1)
            @include('plantilla.sidebaradministrador')
        @elseif (Auth::user()->idroles==2)
            @include('plantilla.sidebaradministradorMuni')
        @elseif (Auth::user()->idroles==3)
            @include('plantilla.sidebartesorero')
        @else
        @endif
    @endif
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Contenido Principal -->
                @if(Auth::check())
                    @yield('contenido')
                @endif
            </div>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">Desarrollado &copy; 2020<a class="text-bold-800 grey darken -2" href="https://www.facebook.com/ScairpGroup" target="_blank">Scairp</a>, All rights Reserved</span><span class="float-md-right d-none d-md-block">Team Scairp<i class="feather icon-heart pink"></i></span>
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">Conectividad &copy; 2020<a class="text-bold-800 grey darken -2" href="https://www.facebook.com/ScairpGroup" target="_blank">Scairp</a>, All rights Reserved</span><span class="float-md-right d-none d-md-block">Carrasco Purisaca Juan<i class="feather icon-heart pink"></i></span>
        </p>
    </footer> -->
    </div>
    <script src="js/plantilla.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
