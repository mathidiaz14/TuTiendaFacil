<div class="row" @if($comentario->parent_id != null) style="margin-left:40px; width:100%;" @endif>
	<div class="col-12 comentario p-3 my-2 text-white" >
		<div class="row">
			<div class="col-6">
				<p>
					<b>{{$comentario->user_name}}</b>
				</p>
			</div>
			<div class="col-6 text-right">
				<p>
					<b>{{$comentario->created_at->format('d/m/Y H:i')}}</b>
				</p>
			</div>
			<div class="col-12">
				<p>{{$comentario->contenido}}</p>
			</div>
			<div class="col-12 text-right">
				<a class="btn-responder btn btn-secondary text-white" attr-id="{{$comentario->id}}" attr-nombre="{{$comentario->user_name}}">
					Responder
				</a>
			</div>
		</div>
	</div>

	@foreach($comentario->hijos->where('estado', 'aprobado') as $hijo)
		@include(ttf_carpeta().'.blog.comentario', ['comentario' => $hijo])
	@endforeach

</div>

