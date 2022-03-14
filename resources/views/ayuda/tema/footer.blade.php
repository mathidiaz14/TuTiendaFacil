
<hr>
<div class='row mt-5'>
	<div class='col'>
		<p>Desarrollado en la plataforma <a href='http://tutiendafacil.uy'>TuTiendaFacil.uy</a> ♥</p>
	</div>
	<div class='col text-right'>
		@if(Auth::check())
            <a href='{{url("admin")}}'>Dashboard</a>
        @else
            <a href='{{url("login")}}'>Iniciar Sesión</a>
        @endif
	</div>
</div>

<meta name='csrf-token' content='{{ Session::token() }}'> 


<script>
    $(document).ready(function()
    {   
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        var dispositivo;

        if( isMobile.Android())
            dispositivo = "Android";
        else if( isMobile.BlackBerry()) 
            dispositivo = "BlackBerry";
        else if( isMobile.iOS()) 
            dispositivo = "iOS";
        else if( isMobile.Opera()) 
            dispositivo = "Opera";
        else if( isMobile.Windows()) 
            dispositivo = "Windows Phone";
        else
            dispositivo = "PC";

        $.get('https://json.geoiplookup.io/', function(res)
        { 
            ip              = res.ip;
            pais            = res.country_name;
            ciudad          = res.city;
            url             = window.location.pathname;
        
        }).done(function(){
            
            if (url == '/')
                url = 'home';

            $.post("{{url('visita')}}",
            {
                _token:         $('meta[name=csrf-token]').attr('content'),
                ip:             ip,
                url:            url,
                ciudad:         ciudad,
                pais:           pais,
                dispositivo:    dispositivo,
            })
        });

    });
</script>

<script src="{{asset('js/csrf.js')}}"></script>
