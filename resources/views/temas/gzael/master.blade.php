<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="{{logo_url()}}" type="image/png" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title> {{i('titulo')}} </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{myasset('assets/css/bootstrap.css')}}" />
  <!-- font awesome style -->
  <link href="{{myasset('assets/css/font-awesome.min.css')}}" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{myasset('assets/css/style.css')}}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{myasset('assets/css/responsive.css')}}" rel="stylesheet" />
  <script src="{{myasset('assets/js/jquery-3.4.1.min.js')}}"></script>

  <style>
  	.slider_section, .about_section, .info_section, .footer_section, .custom_menu-btn::before,.custom_menu-btn.menu_btn-style::before, .carousel-control-next, .carousel-control-prev 
  	{
  		background: {{landing('color1')}}!important;
  	}

    body
    {
      color: {{landing('color_texto')}}!important;
    }

    a
    {
      color: black;
    }

    .btn-primary
    {
      background: {{landing('color1')}}!important;
      border-color: {{landing('color1')}}!important;
    }

    .productos_carrito
    {
      background: white;
      padding: 5px 14px;
      border-radius: 50%;
      color: {{landing('color1')}};
    }

    .navbar-brand span
    {
        color: {{landing('color1')}}!important;
    }

    hr
    {
      border-top-color:rgba(255, 255, 255, 0.2);
    }
  </style>
  @yield('css')

</head>

<body>

  <!-- header section strats -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="{{url('/')}}">
          <span>
            {{i('titulo')}}
          </span>
        </a>
        <div class="" id="">
          <div class="custom_menu-btn">
            <button onclick="openNav()">
              <span class="s-1"> </span>
              <span class="s-2"> </span>
              <span class="s-3"> </span>
            </button>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="{{url('/')}}">Inicio</a>
                <a href="{{url('productos')}}">Productos</a>
                @foreach(paginas() as $pagina)
                	<a href="{{pagina_url($pagina->id)}}">{{$pagina->titulo}}</a>
                @endforeach
                <hr>
                <a href="{{url('carrito')}}">Carrito <b class="productos_carrito">{{cantidad_productos_carrito()}}</b></a>
              </div>
            </div>
          </div>

        </div>
      </nav>
    </div>
  </header>
  
  @yield('contenido')

  <footer class="footer_section">
    <div class="container">
      <section class="info_section ">
        <div class="container-fluid">
          <div class="row info_main_row">
            <div class="col-lg mx-auto py-5">
            <hr>
              <div class="row">
                <div class="col-md info-col">
                  <div class="info_detail">
                    <div class="info_social">
                      @if(landing('facebook') != null)
                        <a href="{{landing('facebook')}}">
                          <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                      @elseif(landing('twitter') != null)
                        <a href="{{landing('twitter')}}">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                      @elseif(landing('linkedin') != null)
                        <a href="{{landing('linkedin')}}">
                          <i class="fa fa-linkedin" aria-hidden="true"></i>
                        </a>
                      @elseif(landing('instagram') != null)
                        <a href="{{landing('instagram')}}">
                          <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-md info-col">
                  <div class="info_contact">
                    <div class="contact_link_box">
                      <a href="{{landing('ubicacion')}}">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span>
                          Ubicación
                        </span>
                      </a>
                      <a href="tel:{{landing('telefono')}}">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span>
                          {{landing('telefono')}}
                        </span>
                      </a>
                      <a href="mailto:{{landing('email')}}">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span>
                          {{i('email_admin')}}
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              {{ttf_footer()}}
            </div>
          </div>
        </div>
      </section>
    </div>
  </footer>
  <!-- footer section -->


  <!-- jQery -->
  <!-- bootstrap js -->
  <script src="{{myasset('assets/js/bootstrap.js')}}"></script>
  <!-- custom js -->
  <script src="{{myasset('assets/js/custom.js')}}"></script>
  <!-- End Google Map -->
</body>

</html>