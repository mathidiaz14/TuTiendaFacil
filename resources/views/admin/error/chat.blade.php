@extends('layouts.dashboard', ['menu_activo' => 'soporte'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Soporte</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Soporte</li>
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
		                  <i class="fas fa-headset"></i>
		                  Soporte técnico en vivo
		                </h3>
                	</div>
                	<div class="col text-right">
	                </div>
            	</div>
				<div class="card-body">
					<!-- Coloque esta etiqueta donde usted quiera que el Plugin Live Helper sea desplegado -->
					<div id="lhc_status_container_page" ></div>

					<!-- Coloque esta etiqueta después de la etiqueta &#039;&#039;Live Helper Plugin&#039;&#039;. -->
					<script type="text/javascript">
					var LHCChatOptionsPage = {'height':300,'mobile':false};
					LHCChatOptionsPage.opt = {};
					(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
					var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
					po.src = '//chat.mathiasdiaz.uy/index.php/esp/chat/getstatusembed/(theme)/1/(department)/1?r='+referrer+'&l='+location;
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					})();
					</script>
				</div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
	
@endsection