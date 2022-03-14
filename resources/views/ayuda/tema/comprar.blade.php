<div class="col-12">
    <form action="{{url('agregar_carrito')}}" class="form-horizontal" method="post">
        @csrf
        <input type="hidden" name="producto" value="{{$producto->id}}" >
        
        @if($producto->variantes->count() > 0)
            <div class="form-group">
                <select name="variante" id="variante" class="form-control">
                    <option value="null">Elija una opcion</option>
                    @foreach($producto->variantes as $variante)
                        @if($variante->cantidad == "0")
                            <option value="null" disabled="" style="background: #dfdfdf;">
                                {{$variante->nombre}} (Sin stock)
                            </option>
                        @else
                            <option value="{{$variante->id}}" 
                                @if($variante->cantidad != null)
                                    attr-max="{{$variante->cantidad}}"
                                @else
                                    attr-max="1000"
                                @endif
                            >
                                {{$variante->nombre}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
        
        <div class="form-group">
            <div class="row">
            	<div class="col-4 col-md-2 mt-2">
            		<a class="btn btn-primary btn-block btn_menos">
            			<i class="fa fa-minus"></i>
            		</a>
            	</div>
                <div class="col-4 col-md-2 mt-2">
                    <input type="number" class="form-control text-center" name="cantidad" id="cantidad" value="1" min="1" 
                    @if($producto->variantes->count() > 0)
                        disabled
                    @else
                        @if($producto->cantidad != null)
                            max="{{$producto->cantidad}}"
                        @else
                            max=1000
                        @endif
                    @endif
                    >
                </div>    
            	<div class="col-4 col-md-2 mt-2">
            		<a class="btn btn-primary btn-block btn_mas">
            			<i class="fa fa-plus"></i>
            		</a>
            	</div>
                <div class="col-12 col-md-6 mt-2">
                    <button class="btn btn-primary btn-block btn_agregar_carrito" 
                    @if($producto->variantes->count() > 0)
                    	disabled
                    @endif
                    >
                        <i class="fa fa-shopping-bag"></i>
                        Agregar al carrito
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@if($producto->variantes->count() == 0)
    <div class="col-12 my-4">
        <a href="{{comprar_ahora($producto->id)}}" class="btn btn-primary btn-block">
            <i class="fa fa-money"></i>
            Comprar ahora
        </a>
    </div>
@endif
@if(wpp_estado())
    <div class="col-12">
        <a href="{{url('ventaPorWpp', $producto->id)}}" target="_blank" class="btn btn-success text-white btn-block">
            <i class="fa fa-whatsapp"></i>    
            Comprar por wpp
        </a>
    </div>    
@endif

<script>
        
	$(document).ready(function()
	{
		@if($producto->variantes->count() > 0)
			$('#variante').change(function()
			{
				$('#cantidad').val(1);
					
				if($("#variante option:selected").val() == "null")
				{
					$('.btn_agregar_carrito').prop('disabled', true);
					$('#cantidad').prop('disabled', true);
					$('#cantidad').attr('max', 1);
				}
				else
				{
					$('.btn_agregar_carrito').prop('disabled', false);
					$('#cantidad').prop('disabled', false);
					$('#cantidad').attr('max', $("#variante option:selected").attr('attr-max'));
				}
			});
		@endif

		$('.btn_mas').click(function()
		{
			if(parseFloat($('#cantidad').val()) + 1 <= $('#cantidad').attr('max'))
				$('#cantidad').val(parseFloat($('#cantidad').val()) + 1);
		});

		$('.btn_menos').click(function()
		{
			if(parseFloat($('#cantidad').val()) > 1)
				$('#cantidad').val(parseFloat($('#cantidad').val()) - 1);
		});
	});

</script>