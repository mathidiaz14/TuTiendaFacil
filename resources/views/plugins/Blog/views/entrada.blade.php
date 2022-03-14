@extends(ttf_extends('master'))

@section('contenido')
	<div class="container">
		<div class="row" style="margin-top: 80px;">
			<div class="col-12 text-center py-5">
				<h1>{{$entrada->titulo}}</h1>
				<a href="{{blog_categoria_url($entrada->categoria)}}"><small>{{blog_categoria_titulo($entrada)}}</small></a>
			</div>
		</div>
		<div class="row">
			
			<div class="col-12 mb-4">
				<img src="{{asset($entrada->imagen)}}" alt="" width="100%">
			</div>
			
			<div class="col-12 my-4">
				{!!$entrada->contenido!!}
			</div>

		</div>
		
		@if(blog_comentarios_activos($entrada))
			<div class="row mb-4">
				<div class="col-12">
					<hr>
					<p><b>Deja un comentario</b></p>
					
					<form action="{{url('blog/comentario', $entrada->id)}}" method="post" class="form-horizontal">
						@csrf
						<input type="hidden" name="parent_id" value="" id="parent_id">
						<p class="parent_id"></p>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Nombre" name="nombre" required="">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email" name="email" required="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<textarea name="contenido" id="" rows="5" class="form-control" placeholder="Comentario" required=""></textarea>
						</div>
						<div class="form-group text-right">
							<button class="btn btn-primary">
								<i class="fa fa-send"></i>
								Enviar
							</button>
						</div>
					</form>
					<hr>
				</div>
				
				@foreach(blog_comentarios($entrada) as $comentario)
					@include(ttf_carpeta().'.blog.comentario', ['comentario' => $comentario])
				@endforeach
				
			</div>
		@endif

	</div>
@endsection

@section('js')
	<script>
		$(document).ready(function()
		{
			$('.btn-responder').click(function()
			{
				$('#parent_id').val($(this).attr('attr-id'));
				$('.parent_id').html('En respuesta a: '+$(this).attr('attr-nombre'));
			});
		});
	</script>
@endsection