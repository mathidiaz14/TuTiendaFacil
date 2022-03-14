<!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-info">
    <!-- Brand Logo -->
    <a href="@if(Auth::user()->empresa->estado == 'completo') http://{{Auth::user()->empresa->URL}} @else # @endif" class="brand-link">
      <img src="{{asset('img/favicon_blanco.png')}}" class="brand-image">
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
        <ul class="nav nav-pills nav-sidebar flex-column pb-5" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item ">
            <a href="{{url('/admin')}}" class="nav-link @if($menu_activo == 'inicio') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('admin/venta')}}" class="nav-link @if($menu_activo == 'venta') active @endif">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Pedidos
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('admin/producto')}}" class="nav-link @if($menu_activo == 'producto') active @endif">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Productos
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="{{url('admin/categoria')}}" class="nav-link @if($menu_activo == 'categoria') active @endif">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Categorías
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('admin/cliente')}}" class="nav-link @if($menu_activo == 'cliente') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('admin/proveedor')}}" class="nav-link @if($menu_activo == 'proveedor') active @endif">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Proveedores
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{url('admin/cupon')}}" class="nav-link @if($menu_activo == 'cupon') active @endif">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>
                Cupones
              </p>
            </a>
          </li>
          
          <li class="nav-item 
          @if(($menu_activo == 'visual') or ($menu_activo == 'temas') or ($menu_activo == 'personalizar') or ($menu_activo == 'codigo') or ($menu_activo == 'pagina')) 
            menu-open 
          @endif">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-palette"></i>
              <p>
                Apariencia
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item pl-2">
                <a href="@if(Auth::user()->empresa->estado == 'completo') http://{{Auth::user()->empresa->URL}} @else # @endif" target="_blank" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ver la web</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/pagina')}}" class="nav-link @if($menu_activo == 'pagina') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Paginas</p>
                </a>
              </li>
              
              <li class="nav-item pl-2">
                <a href="{{url('admin/web')}}" class="nav-link @if($menu_activo == 'personalizar') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Personalizar web</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/tema')}}" class="nav-link @if($menu_activo == 'temas') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Temas</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/web/codigo')}}" class="nav-link @if($menu_activo == 'codigo') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editar codigo</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item 
          @if(($menu_activo == 'configuracion') or ($menu_activo == 'usuario') or ($menu_activo == 'error') or ($menu_activo == 'soporte') or ($menu_activo == 'notificacion') or ($menu_activo == 'mensaje') or ($menu_activo == 'visitas') or ($menu_activo == 'plugin') or ($menu_activo == 'newsletter')) 
            menu-open 
          @endif">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Administrar
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item pl-2 ">
                <a href="{{url('admin/configuracion')}}" class="nav-link @if($menu_activo == 'configuracion') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Configuración
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/plugin')}}" class="nav-link @if($menu_activo == 'plugin') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Plugins</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/usuario')}}" class="nav-link @if($menu_activo == 'usuario') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Usuarios
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/newsletter')}}" class="nav-link @if($menu_activo == 'newsletter') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Suscriptores
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/error')}}" class="nav-link @if($menu_activo == 'error') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Incidencias
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/error/soporte')}}" class="nav-link @if($menu_activo == 'soporte') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Soporte
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/notificacion')}}" class="nav-link @if($menu_activo == 'notificacion') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Notificaciones
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/mensaje')}}" class="nav-link @if($menu_activo == 'mensaje') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Mensajes
                  </p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="{{url('admin/visita')}}" class="nav-link @if($menu_activo == 'visitas') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Estadisticas
                  </p>
                </a>
              </li>
            </ul>
          </li>
          {{-- Seccion de plugins --}}
          
          @php
            $flag = false;
          @endphp

          @foreach(Auth::user()->empresa->plugins as $plugin)
            @if($plugin->pivot->estado == "activo")
              @if(view()->exists('plugins.'.$plugin->carpeta.".menu"))
                @php 
                  $flag = true;
                @endphp
              @endif
            @endif
          @endforeach

          @if($flag)

            <li>
              <hr style="border-color:#C2C7D0;">
            </li>

            <li>
              <p class="text-secondary ml-4">Plugins</p>
            </li>

            @foreach(Auth::user()->empresa->plugins as $plugin)
              @if($plugin->pivot->estado == "activo")
                @if(view()->exists('plugins.'.$plugin->carpeta.".menu"))
                  @include('plugins.'.$plugin->carpeta.".menu")
                @endif
              @endif
            @endforeach

          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>