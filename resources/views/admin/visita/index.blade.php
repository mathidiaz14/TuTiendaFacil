@extends('layouts.dashboard', ['menu_activo' => 'visitas'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Estadisticas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Estadisticas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-12">
          	@include('ayuda.alerta')
            <div class="card">
              	<div class="card-header">
	                <div class="row">
	                	<div class="col">
	                		<h3 class="card-title">
			                  <i class="fas fa-chart-pie"></i>
			                  Estadisticas
			                </h3>
	                	</div>
	                	<div class="col text-right">
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#resetearVisitas">
                        <i class="fa fa-eraser"></i>
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="resetearVisitas" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header bg-gradient-info">
                              <h4>Limpiar historial</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <div class="modal-body text-center">
                                <form action="{{url('admin/visita')}}" method="post" class="form-vertical">
                                  @csrf
                                  <div class="row">
                                    <div class="col-9">
                                      <select name="desde" id="" class="form-control">
                                        <option value="1">Ultimo mes</option>
                                        <option value="3">Ultimos 3 meses</option>
                                        <option value="6">Ultimos 6 meses</option>
                                        <option value="12">Ultimo año</option>
                                        <option value="principio">Desde el principio</option>
                                      </select>
                                    </div>
                                    <div class="col-3">
                                      
                                      <button class="btn btn-info btn-block">
                                        <i class="fa fa-eraser"></i>
                                      </button>
                                    </div>
                                  </div>
                                </form>
                                
                              </div>
                            </div>
                        </div>
                      </div>
	                	</div>
	                </div>
          		</div>
        				<div class="card-body">
        					<div class="row">
  		                <div class="col-xs-12 col-md-6">
  		                  	<canvas id="graficaVisitantes" width="100%"></canvas>
  		                </div>
                      <div class="col-xs-12 col-md-6">
                          <canvas id="graficaVisitantesMensuales" width="100%"></canvas>
                      </div>
  		                <div class="col-xs-12 col-md-6">
  		                  	<canvas id="graficaPaginasVisitadas" width="100%"></canvas>
  		                </div>
  		                <div class="col-xs-12 col-md-6">
  		                  	<canvas id="graficaPaises" width="100%"></canvas>
  		                </div>
  		                <div class="col-xs-12 col-md-6">
  		                  	<canvas id="graficaCiudades" width="100%"></canvas>
  		                </div>
                      <div class="col-xs-12 col-md-6">
                          <canvas id="graficaDispositivos" width="100%"></canvas>
                      </div>
              	 </div>
                 <hr>
    				<div class="table table-responsive">
    					<p>Estadisticas detalladas - ({{Auth::user()->empresa->visitas->count()}} registros)</p>
                        <table class="table table-striped">
    						<tr>
    							<th>URL</th>
    							<th>IP</th>
                                <th>Dispositivo</th>
    							<th>Pais</th>
    							<th>Ciudad</th>
    							<th>Fecha</th>
    							<th>Eliminiar</th>
    						</tr>
    						@foreach($visitas as $visita)
    							<tr>
    								<td>{{$visita->url}}</td>
                                    <td>{{$visita->ip}}</td>
    								<td>{{$visita->dispositivo}}</td>
    								<td>{{$visita->pais}}</td>
    								<td>{{$visita->ciudad}}</td>
    								<td>{{$visita->created_at->format('d/m/Y')}}</td>
    								<td>
    									@include('ayuda.eliminar', ['id' => $visita->id, 'ruta' => url('admin/visita', $visita->id)])
    								</td>
    							</tr>
    						@endforeach
    					</table>
    				</div>
                    @include('ayuda.links', ['link' => $visitas])
    			</div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
  
  <script>
    var ctx = document.getElementById('graficaVisitantes').getContext('2d');
    var graficaVisitantes = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
              @for($i = 9; $i >= 0; $i --)
                "{{$days[$i][1]}}",
              @endfor
            ],
            datasets: [{
                label: 'Visitantes diarios',
                data: [
                  @for($i = 9; $i >= 0; $i --)
                    "{{$days[$i][0]}}",
                  @endfor    
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('graficaVisitantesMensuales').getContext('2d');
    var graficaVisitantesMensuales = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
              
              @for($i = 6; $i >= 0; $i--)
                "{{\Carbon\Carbon::now()->subMonth($i)->format('M')}}", 
              @endfor

            ],
            datasets: [{
                label: 'Visitantes menusales',
                data: [

                  @for($i = 6; $i >= 0; $i--)
                    {{Auth::user()->empresa->visitas->wherebetween('fecha', [\Carbon\Carbon::now()->subMonth($i)->firstOfMonth(), \Carbon\Carbon::now()->subMonth($i)->lastOfMonth()])->count()}}, 
                  @endfor
                   
                ],
                backgroundColor: [
                    'rgba(26,252,80,0.5)'
                ],
                borderColor: [
                    'rgba(26,252,80,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('graficaPaginasVisitadas');
    var graficaPaginasVisitadas = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
              @foreach($path as $p)
                "{{$p->url}}",
              @endforeach
            ],
            datasets: [{
                label: 'Paginas visitadas',
                data: [
                  @foreach($path as $p)
                    "{{$p->views}}",
                  @endforeach
                ],
                backgroundColor: [
                    @foreach($path as $p)
                      "@php
                        echo "rgba(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).",0.5)";
                      @endphp",
                    @endforeach
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('graficaCiudades');
    var graficaCiudades = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
              @foreach($city as $c)
                "{{$c->ciudad}}",
              @endforeach
            ],
            datasets: [{
                label: 'Ciudades',
                data: [
                  @foreach($city as $c)
                    "{{$c->views}}",
                  @endforeach
                ],
                backgroundColor: [
                    @foreach($city as $c)
                      "@php
                        echo "rgba(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).",0.5)";
                      @endphp",
                    @endforeach
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('graficaPaises');
    var graficaPaises = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
              @foreach($country as $c)
                "{{$c->pais}}",
              @endforeach
            ],
            datasets: [{
                label: 'Paises',
                data: [
                  @foreach($country as $c)
                    "{{$c->views}}",
                  @endforeach
                ],
                backgroundColor: [
                    @foreach($country as $c)
                      "@php
                        echo "rgba(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).",0.5)";
                      @endphp",
                    @endforeach
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('graficaDispositivos');
    var graficaDispositivos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
              @foreach(Auth::user()->empresa->visitas->groupBy('dispositivo') as $visita)
                "{{$visita->first()->dispositivo}}",
              @endforeach
            ],
            datasets: [{
                label: 'Dispositivos',
                data: [
                  @foreach(Auth::user()->empresa->visitas->groupBy('dispositivo') as $visita)
                    "{{$visita->count()}}",
                  @endforeach
                ],
                backgroundColor: [
                    @foreach($country as $c)
                      "@php
                        echo "rgba(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).",0.5)";
                      @endphp",
                    @endforeach
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
  </script>
@endsection