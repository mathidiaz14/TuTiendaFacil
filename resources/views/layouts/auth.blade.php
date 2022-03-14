<!DOCTYPE html>
<html lang="es">
<head>
	<title>TuTiendaFacil.uy</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('auth/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('auth/css/main.css')}}">
<!--===============================================================================================-->
	@yield('css')
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                
                @yield('contenido')

                <div class="login100-more" style="background-image: url('{{asset('auth/images/bg-01.jpg')}}');">
                </div>
            </div>
        </div>
    </div>

    @yield('')

	
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('auth/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('auth/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('auth/js/main.js')}}"></script>

	@yield('scripts')

	<script src="{{asset('js/csrf.js')}}"></script>

</body>
</html>