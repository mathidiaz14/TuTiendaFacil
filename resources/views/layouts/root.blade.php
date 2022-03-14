<!DOCTYPE html>
<html lang="en">
<head>
  <title>TuTiendaFacil.uy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/summernote/summernote-bs4.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  
  <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
  
  @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('admin')}}" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span>
            {{Auth::user()->nombre}}
            <i class="fa fa-chevron-down"></i>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{url('root/perfil')}}" class="dropdown-item">
            <i class="fa fa-user"></i>
            Mi perfil
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item"
              onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out-alt"></i>
              Cerrar Sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-info">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
      <img src="{{asset('img/favicon_blanco.png')}}" alt="AdminLTE Logo" class="brand-image">
      <span class="brand-text font-weight-light titulo-pagina">TuTiendaFacil</span>
      <span class="titulo-pagina-uy">.uy</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <span class="d-block text-white">
            Hola
          </span>
          <b class="text-white">
            {{Auth::user()->nombre}}
          </b>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item ">
            <a href="{{url('/admin')}}" class="nav-link @if($menu_activo == 'inicio') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('root/empresa')}}" class="nav-link @if($menu_activo == 'empresa') active @endif">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Empresas
              </p>
            </a>
          </li>
           <li class="nav-item ">
            <a href="{{url('root/usuario')}}" class="nav-link @if($menu_activo == 'usuario') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('root/venta')}}" class="nav-link @if($menu_activo == 'venta') active @endif">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Ventas
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('root/codigo')}}" class="nav-link @if($menu_activo == 'codigo') active @endif">
              <i class="nav-icon fas fa-code"></i>
              <p>
                Codigos
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('root/opcion')}}" class="nav-link @if($menu_activo == 'opcion') active @endif">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Opciones
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('root/error')}}" class="nav-link @if($menu_activo == 'error') active @endif">
              <i class="nav-icon fa fa-exclamation-circle"></i>
              <p>
                Reportes
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('root/ayuda')}}" class="nav-link @if($menu_activo == 'ayuda') active @endif">
              <i class="nav-icon fa fa-question"></i>
              <p>
                Ayuda
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('root/administrar')}}" class="nav-link @if($menu_activo == 'administrar') active @endif">
              <i class="nav-icon fa fa-download"></i>
              <p>
                Administrar sitio
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('root/log')}}" class="nav-link @if($menu_activo == 'log') active @endif">
              <i class="nav-icon fa fa-list"></i>
              <p>
                Log
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('contenido')

  @include('layouts.partes.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('dashboard/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('dashboard/plugins/sparklines/sparkline.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('dashboard/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('dashboard/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('dashboard/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dashboard/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  @yield('scripts')

  
  <script src="{{asset('js/csrf.js')}}"></script>
</body>
</html>
