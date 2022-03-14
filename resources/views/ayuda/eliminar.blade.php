<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal_{{$id}}">
	<i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade deleteModal" id="deleteModal_{{$id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-dialog-centered" role="document">
  		<div class="modal-content">
			<div class="modal-header bg-gradient-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
    		</div>
    		<div class="modal-body text-center">
    			<p><i class="fa fa-exclamation-triangle fa-4x"></i></p>
      			<h4>¿Desea eliminar el item?</h4>
      			<br>
            <hr>
      			<div class="row">
      				<div class="col">
    						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
    							NO
    						</button>
      				</div>
      				<div class="col">
      					<form action="{{ $ruta }}" method="POST">
                    @csrf
                    <input type='hidden' name='_method' value='DELETE'>
                    <button class="btn btn-danger btn-block">
                        SI
                    </button>
                </form>
      				</div>
      			</div>
    		</div>
  		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on("keydown", function(e) 
	{
		var code = e.keyCode || e.which;
		if(code == 13) 
		{
			$('.deleteModal').each(function()
			{
				if($(this).hasClass('show'))
				{
					var modal = $(this).attr('id');
					console.log($("#"+modal+" form").submit());
				}
			});
		}
	});
</script>