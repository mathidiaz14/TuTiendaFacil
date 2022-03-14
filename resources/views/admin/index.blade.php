@extends('layouts.dashboard', ['menu_activo' => 'inicio'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      @include('ayuda.alerta')
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  @php
                    $ventas_mes_actual = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', '!=', 'comenzado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()])
                                                      ->count();

                    $ventas_mes_anterior = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', '!=', 'comenzado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)])
                                                      ->count();
                  @endphp
                  {{$ventas_mes_actual}}
                </h3>

                <p>Ordenes totales</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a class="small-box-footer">
                Mes anterior a la fecha: {{$ventas_mes_anterior}}
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                   @php
                    $ventas_mes_actual_completadas = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', 'entregado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()])
                                                      ->count();

                    $ventas_mes_anterior_completadas = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', 'entregado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)])
                                                      ->count();
                  @endphp
                  {{$ventas_mes_actual_completadas}}
                </h3>

                <p>Ordenes completas</p>
              </div>
              <div class="icon">
                <i class="fa fa-hand-holding-usd"></i>
              </div>
              <a class="small-box-footer">
                Mes anterior a la fecha: {{$ventas_mes_anterior_completadas}}
              </a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>
                  @php
                    $visitas_mes_actual = Auth::user()->empresa
                                                      ->visitas
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()])
                                                      ->count();

                    $visitas_mes_anterior = Auth::user()->empresa
                                                      ->visitas
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)])
                                                      ->count();
                  @endphp
                  {{$visitas_mes_actual}}
                </h3>

                <p>Visitas a la web</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a class="small-box-footer">
                Mes anterior a la fecha: {{$visitas_mes_anterior}}
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                   @php
                    $monto_mes_actual = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', 'aprobado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()])
                                                      ->sum('precio');

                    $monto_mes_anterior = Auth::user()->empresa
                                                      ->ventas
                                                      ->where('estado', 'aprobado')
                                                      ->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)])
                                                      ->sum('precio');
                  @endphp
                  ${{$monto_mes_actual}}
                </h3>

                <p>Monto de ventas</p>
              </div>
              <div class="icon">
                <i class="fa fa-money-bill"></i>
              </div>
              <a class="small-box-footer">
                Mes anterior a la fecha: ${{$monto_mes_anterior}}
              </a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Main row -->
        <div class="row">
          <div class="col-12 col-md-6">
            <section class="col-lg-12 connectedSortable">
              <div class="card bg-gradient-secundary">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    Ordenes
                  </h3>
                </div>
                <div class="card-body">
                   <canvas id="graficaVentas" width="100%"></canvas>
                </div>
              </div>
            </section>
          </div>       

          <div class="col-12 col-md-6">
            <section class="col-lg-12 connectedSortable">
              <div class="card bg-gradient-secundary">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-money-bill mr-1"></i>
                    Monto facturado
                  </h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaMonto" width="100%"></canvas>
                </div>
              </div>
            </section>
          </div> 
        </div>

        {{-- Seccion de plugins --}}

        @foreach(Auth::user()->empresa->plugins as $plugin)
          @if($plugin->pivot->estado == "activo")
            @if(view()->exists('plugins.'.$plugin->carpeta.".dashboard"))
              @include('plugins.'.$plugin->carpeta.".dashboard")
            @endif
          @endif
        @endforeach

      </div>
    </section>
  </div>
@endsection

@section('scripts')
  <script>
    var ctx = document.getElementById('graficaVentas').getContext('2d');
    var taskChart = new Chart(ctx, {
      type: 'line',
        data: {
            labels: [
              "{{\Carbon\Carbon::now()->subMonth(6)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(5)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(4)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(3)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(2)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(1)->format('M')}}", 
              "{{\Carbon\Carbon::now()->format('M')}}"
                ],
            datasets: [{
                label: "Ordenes completas",
                backgroundColor: "#007BFF",
                borderColor: "#196dc6",
                pointBorderColor: "#196dc6",
                pointBackgroundColor: "#196dc6",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#196dc6",
                pointBorderWidth: 1,
                data: [
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(6)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(6)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(5)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(5)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(4)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(4)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(3)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(3)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(2)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(2)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'entregado')->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()->lastOfMonth()])->count()}}
                ]
            },{
                label: "Ordenes totales",
                backgroundColor: "#17A2B8",
                borderColor: "#108da0",
                pointBorderColor: "#108da0",
                pointBackgroundColor: "#108da0",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#108da0",
                pointBorderWidth: 1,
                data: [
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(6)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(6)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(5)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(5)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(4)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(4)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(3)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(3)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(2)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(2)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)->lastOfMonth()])->count()}}, 
                    {{Auth::user()->empresa->ventas->where('estado', '!=', 'comenzado')->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()->lastOfMonth()])->count()}}
                ]
            }]
        },
    }); 

    /************************************/


    var ctx = document.getElementById('graficaMonto').getContext('2d');
    var taskChart = new Chart(ctx, {
      type: 'line',
        data: {
            labels: [
              "{{\Carbon\Carbon::now()->subMonth(6)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(5)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(4)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(3)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(2)->format('M')}}", 
              "{{\Carbon\Carbon::now()->subMonth(1)->format('M')}}", 
              "{{\Carbon\Carbon::now()->format('M')}}"
                ],
            datasets: [{
                label: "Monto",
                backgroundColor: "#FFC107",
                borderColor: "#e5ad04",
                pointBorderColor: "#e5ad04",
                pointBackgroundColor: "#e5ad04",
                pointHoverBackgroundColor: "#e5ad04",
                pointHoverBorderColor: "#e5ad04",
                pointBorderWidth: 1,
                data: [
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(6)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(6)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(5)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(5)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(4)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(4)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(3)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(3)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(2)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(2)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->subMonth(1)->firstOfMonth(), \Carbon\Carbon::now()->subMonth(1)->lastOfMonth()])->sum('precio')}}, 
                    {{Auth::user()->empresa->ventas->where('estado', 'aprobado')->wherebetween('created_at', [\Carbon\Carbon::now()->firstOfMonth(), \Carbon\Carbon::now()->lastOfMonth()])->sum('precio')}}
                ]
            }]
        },
    });

  </script>
@endsection