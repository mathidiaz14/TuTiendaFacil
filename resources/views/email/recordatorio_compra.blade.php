<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
	<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
	<meta content="width=device-width" name="viewport"/>
	<!--[if !mso]><!-->
	<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
	<!--<![endif]-->
	<title></title>
	<!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
	<style>
		@font-face {
			font-family: Poppins;
			src: url("{{asset('fuentes/Poppins-Medium.ttf')}}");
		}

		*{
			margin:0;
			font-family: Poppins;
		}

		.btn
		{
			text-decoration: none;
			background: #235693;
			padding: 10px;
			border-radius: 5px;
			color:white;
		}
	</style>
</head>
<body>
	<table class="full-width-container" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#00B36F" style="width: 100%; height: 100%; padding: 30px 0 30px 0;">
			<tr>
				<td align="center" valign="top">
					<!-- / 700px container -->
					<table class="container" border="0" cellpadding="0" cellspacing="0" width="700" bgcolor="#ffffff" style="width: 700px;">
						<tr>
							<td align="center" valign="top">
								<!-- / Header -->
								<table class="container header" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
									<tr>
										<td style="padding: 30px 0 30px 0; border-bottom: solid 1px #eeeeee;" align="center">
											<img src="{{asset('img/favicon.png')}}" alt="" width="50px" style="opacity:0.5;">
										</td>
									</tr>
								</table>
								<!-- /// Header -->

								<!-- / Hero subheader -->
								<table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
									<tr>
										<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 20px 0 15px 0; border-bottom: solid 1px #eeeeee;" align="center">
											Finaliza tu compra
										</td>
									</tr>

									<tr>
										<td class="hero-subheader__content" style=" line-height: 27px; color: #969696; padding: 0 0px 30px 0;" align="center">
											<br><br>
											<p>Recuerda que tienes una compra sin finalizar en la pagina {{$contenido['pagina']}}, puedes retomarla haciendo click en el siguiente enlace</p>
											<br><br>
											<a href="{{$contenido['url']}}">Finalizar compra</a>
										</td>
									</tr>
								</table>
								<!-- /// Hero subheader -->

								<!-- / Divider -->
								<table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
									<tr>
										<td align="center">
											<table class="container" border="0" cellpadding="0" cellspacing="0"  align="center" style="border-bottom: solid 1px #eeeeee;;">
											</table>
										</td>
									</tr>
								</table>
								<!-- /// Divider -->

								<!-- / Footer -->
								<table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
									<tr>
										<td align="center">
											<table class="container" border="0" cellpadding="0" cellspacing="0" width="620" align="center" style="border-top: 1px solid #eeeeee; width: 620px;">
												<tr>
													<td style="text-align: center; padding: 50px 0 10px 0;">
														<a href="#" style="font-size: 28px; text-decoration: none; color: #d5d5d5;">TuTiendaFacil.uy</a>
													</td>
												</tr>

												<tr>
												</tr>

												<tr>
													<td style="color: #d5d5d5; text-align: center; font-size: 15px; padding: 10px 0 60px 0; line-height: 22px;">Este mensaje se genero automaticamente, <br />por favor no responda</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- /// Footer -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
</body>
</html>
