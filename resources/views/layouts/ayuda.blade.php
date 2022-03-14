<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>TuTiendaFacil.uy - Ayuda</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{asset('help/assets/css/main.css')}}" />
		<noscript><link rel="stylesheet" href="{{asset('help/assets/css/noscript.css')}}" /></noscript>
		<link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">

	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">
							<!-- Logo -->
							<a href="{{url('ayuda')}}" class="logo">
								<span class="symbol"><img src="{{asset('img/favicon.png')}}" alt="" /></span><span class="title">TuTiendaFacil.uy</span>
							</a>
						</div>
					</header>


					@yield('contenido')

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<section></section>
							<section>
								<ul class="icons">
									<li><a href="https://www.instagram.com/tutiendafacil.uy/" class="icon brands style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="mailto:admin@tutiendafacil.uy" class="icon solid style2 fa-envelope"><span class="label">Email</span></a></li>
								</ul>
							</section>
							<ul class="copyright">
								<li>Desarrollado por <a href="http://tutiendafacil.uy">TuTiendaFacil.uy</a></li>
							</ul>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="{{asset('help/assets/js/jquery.min.js')}}"></script>
			<script src="{{asset('help/assets/js/browser.min.js')}}"></script>
			<script src="{{asset('help/assets/js/breakpoints.min.js')}}"></script>
			<script src="{{asset('help/assets/js/util.js')}}"></script>xº
			<script src="{{asset('help/assets/js/main.js')}}"></script>

	</body>
</html>