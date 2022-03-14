@extends('layouts.dashboard', ['menu_activo' => 'plugin'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
            	<i class="fa fa-plug"></i>
            	Plugins
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
	        	<div class="col-12">
					<ul class="nav nav-tabs" id="tab">
						<li class="nav-item">
							<a class="nav-link active" href="#misPlugins">
								<b>Mis Plugins</b>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#otrosPlugins">
								<b>Tienda</b>
							</a>
						</li>
					</ul>
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="tab-content" id="myTabContent">
									  	<div class="tab-pane fade show active" id="misPlugins" role="tabpanel" aria-labelledby="home-tab">
									  		@include('admin.plugin.misPlugins')
									  	</div>
									  	<div class="tab-pane fade" id="otrosPlugins" role="tabpanel" aria-labelledby="profile-tab">
											@include('admin.plugin.otrosPlugins')
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