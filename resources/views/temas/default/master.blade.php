<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>{{i('titulo')}}</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{myasset('assets/style.css')}}">
	<link rel="icon" type="image/png" href="{{logo_url()}}">

	@yield('css')

	<style>
		p, a
		{
			color: {{landing('color_texto')}}!important;
		}

		.btn-primary
		{
			background: {{landing('color1')}}!important;
			border-color: {{landing('color1')}}!important;
			color: {{landing('color_texto')}}!important;
		}

		.numero_productos_carrito
		{
			background: {{landing('color1')}}!important;
			padding: 5px 10px;
			border-radius: 50%;
		}

		footer, .comentario
		{
		    background: {{landing('color1')}}!important;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	

</head>
<body>
	<nav id="sidebar">
        <div id="dismiss">
            <i class="fa fa-times"></i>
        </div>

        <ul class="list-unstyled components p-4">
           	<li class="my-4">
           		<form action="{{url('productos')}}" method='get' class='form-horizontal'>
			        <div class="row">
			        	<div class="col-10">
			        		<input type='text' class='form-control'name='busqueda' placeholder='Buscar...'>
			        	</div>
			        	<div class="col-1">
			        		<button class="btn">
			        			<i class="fa fa-search"></i>
			        		</button>
			        	</div>
			        </div>
				</form>
           	</li>

			@if(plugin_blog_instalado())
				<li class="nav-item">
					<a class="nav-link" href="{{url('blog')}}">
						<b>Blog</b>
					</a>
				</li>
			@endif

			<li class="nav-item">
				<a class="nav-link" href="{{url('productos')}}">
					<b>Productos</b>
				</a>
			</li>
			
			@foreach(categorias() as $categoria)
				<li class="nav-item">
					<a class="nav-link" href="{{url('categoria', $categoria->url)}}">
						<b>{{$categoria->titulo}}</b>
					</a>
				</li>
			@endforeach 
			
			@foreach(empresa()->paginas as $pagina)
				<li class="nav-item">
					<a class="nav-link" href="{{url('pagina', $pagina->url)}}">
						<b>{{$pagina->titulo}}</b>
					</a>
				</li>
			@endforeach 

        </ul>
    </nav>

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn">
                <i class="fa fa-bars"></i>
                Menu
            </button>

            <a class="navbar-brand" href="{{url('/')}}">
				<h2 class="titulo">
					{{i('titulo')}}
				</h2>
			</a>

			<a href="{{url('carrito')}}" class="btn">
				<i class="fa fa-shopping-cart"></i>
				@if(cantidad_productos_carrito() > 0)
					<span class="numero_productos_carrito">
						{{cantidad_productos_carrito()}}
					</span>
				@endif
			</a>
        </div>
    </nav>

	
	@yield('contenido')
	<footer>
		<div class="container py-5">
			<div class="row text-center">
				<div class="col-12 py-2">
					<a href="http://instagram.com/{{landing('instagram')}}" class="px-3">
						<i class="fa fa-2x fa-instagram"></i>
					</a>
					<a href="http://facebook.com/{{landing('facebook')}}" class="px-3">
						<i class="fa fa-2x fa-facebook"></i>
					</a>
				</div>
				<div class="col-12 py-2">
					<a href="tel:{{landing('telefono')}}">
						<b><i class="fa fa-phone"></i> {{landing('telefono')}}</b>
					</a>
				</div>
				<div class="col-12 py-2">
					<a href="mailto:{{i('email_admin')}}">
						<b><i class="fa fa-envelope"></i> {{i('email_admin')}}</b>
					</a>
				</div>
				<div class="col-12 py-2">
					<b><i class="fa fa-home"></i> {{landing('direccion')}}</b>
				</div>
			</div>
			
			{!! ttf_footer() !!}
		</div>
	</footer>

	@yield('js')
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>
</html>