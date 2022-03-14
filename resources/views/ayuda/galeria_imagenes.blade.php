
<link rel="stylesheet" href="{{asset('css/baguetteBox.css')}}">
<link rel="stylesheet" href="{{asset('css/gallery-grid.css')}}">

<div class="tz-gallery">
	<div class="row">
	    
		<div class="col-12">
            <a class="lightbox" href="{{producto_url_imagen($producto->id)}}">
            	<img src="{{producto_url_imagen($producto->id)}}" alt="" width="100%">
            </a>
		</div>
		
        @foreach($producto->multimedia as $multimedia)
			@if(asset($multimedia->url) != producto_url_imagen($producto->id))
				<div class="col-4">
	                <a class="lightbox" href="{{asset($multimedia->url)}}">
	                	<img src="{{asset($multimedia->url)}}" alt="" width="100%">
	                </a>
				</div>
			@endif
		@endforeach
	</div>	
</div>

<script src="{{asset('js/baguetteBox.js')}}"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>