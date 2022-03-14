<div class="ml-4 my-2">
	<div class="row @if($categoria->parent_id == null) bg-gradient-dark @else bg-gradient-secondary @endif p-2 rounded">
		<div class="col-10">
			@if($categoria->padre != null)
				<i class="fa fa-reply fa-rotate-180 mr-3"></i>
			@endif

			<a href="{{url('ayuda/categoria', $categoria->id)}}" class="text-white" target="_blank">
				{{$categoria->titulo}}
			</a>
		</div>
		<div class="col-2 text-right text-dark">
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarCategoria_{{$categoria->id}}">
				<i class="fa fa-edit"></i>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="editarCategoria_{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content text-left">
			        <div class="modal-header">
			          <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
			          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span>
			          </button>
			        </div>
			        <div class="modal-body">
						<form action="{{url('root/ayuda', $categoria->id)}}" method="POST" class="form-horizontal">
							@csrf
							@method('PATCH')
							<div class="form-group">
								<label for="">Titulo</label>
								<input type="text" name="titulo" class="form-control" value="{{$categoria->titulo}}">
							</div>
							<div class="form-group">
								<label for="">Debajo de</label>
								<select name="parent_id" id="" class="form-control">
									@if($categoria->id == null)
										<option value="" selected="">
											Ninguna
										</option>
									@else
										<option value="">
											Ninguna
										</option>
									
									@endif

									@foreach($categorias as $categoria2)
										@if($categoria->parent_id == $categoria2->id)
											<option value="{{$categoria2->id}}" selected="">
												{{$categoria2->titulo}}
											</option>
										@else
											<option value="{{$categoria2->id}}">
												{{$categoria2->titulo}}
											</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="form-group text-right">
								<button class="btn btn-info">
									<i class="fa fa-save"></i>
									Guardar
								</button>
							</div>	
						</form>          
			        </div>
			    </div>
			  </div>
			</div>
			@include('ayuda.eliminar', ['id' => $categoria->id, 'ruta' => url('root/ayuda', $categoria->id)])		
		</div>
	</div>

	@foreach($categoria->entradas as $entrada)
		@include('root.ayuda.entrada', ['entrada' => $entrada])
	@endforeach

	@foreach($categoria->hijos as $hijo)
		@include('root.ayuda.tabla', ['categoria' => $hijo])
	@endforeach
</div>