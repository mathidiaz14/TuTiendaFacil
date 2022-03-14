@extends('layouts.dashboard', ['menu_activo' => 'temas'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
            	<i class="fa fa-palette"></i>
            	Temas
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Web</li>
              <li class="breadcrumb-item active">Temas</li>
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
	        <div class="row">
				<div class="col-12 text-right">		
					<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#instalarTema">
						<i class="fa fa-upload"></i>
						Subir tema
					</button>

					<div class="modal fade text-left" id="instalarTema" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
						<div class="modal-dialog" role="document">
					  		<div class="modal-content">
								<div class="modal-header">
									<div class="col">
										<h5>Subir un nuevo tema</h5>
									</div>
									<div class="col">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
					    		</div>
					    		<div class="modal-body">
					    			<div class="row">
					    				<div class="col">
					    					<form action="{{url('admin/tema')}}" method="post" class="form-horiontal" enctype="multipart/form-data">
						    					@csrf
						    					<div class="form-group">
						    						<label for="">Cargar archivo</label>
						    						<input type="file" name="archivo" class="form-control" accept=".zip" required="">
						    					</div>
						    					<small>Los archivos podran ser analizados por nuestro equipo en busca de codigo malicioso.</small>
						    					<hr>
						    					<div class="row">
						    						<div class="col">
								      					<button type="button" class="btn btn-secondary" data-dismiss="modal">
							    							<i class="fa fa-chevron-left"></i>
							    							Atras
							    						</button>
									    			</div>
									    			<div class="col text-right">
								    					<div class="form-group">
								    						<button class="btn btn-primary">
								    							<i class="fa fa-upload"></i>
								    							Subir
								    						</button>
								    					</div>
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
	        	<div class="col-12">
					<ul class="nav nav-tabs" id="tab">
						<li class="nav-item">
							<a class="nav-link active" href="#misTemas">
								<b>Mis Temas</b>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#otrosTemas">
								<b>Tienda</b>
							</a>
						</li>
					</ul>
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="tab-content" id="myTabContent">
									  	<div class="tab-pane fade show active" id="misTemas" role="tabpanel" aria-labelledby="home-tab">
									  		@include('admin.tema.misTemas')
									  	</div>
									  	<div class="tab-pane fade" id="otrosTemas" role="tabpanel" aria-labelledby="profile-tab">
											@include('admin.tema.otrosTemas')
									  	</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	        </div>
      	</div>
    </section>
  </div>
@endsection

@section('scripts')
	<script>
		$('#tab a').on('click', function (e) {
		  	e.preventDefault()
		  	$(this).tab('show')
		});
	</script>
@endsection