<!--
	
 ______                                                 _                      
|  ___ \                                               | |                     
| | _ | | ____ ____   ____ _   _    _ _ _  ____  ___   | | _   ____  ____ ____ 
| || || |/ _  |  _ \ / _  | | | |  | | | |/ _  |/___)  | || \ / _  )/ ___) _  )
| || || ( ( | | | | ( ( | |\ V /   | | | ( ( | |___ |  | | | ( (/ /| |  ( (/ / 
|_||_||_|\_||_|_| |_|\_||_| \_/     \____|\_||_(___/   |_| |_|\____)_|   \____)
                                                                               
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		@hasSection('title')
			{{ ucfirst(config('app.name')) }} - @yield('title')
	    @else
			{{ ucfirst(config('app.name')) }}
		@endif
	</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#424242">
	<meta name="description" content="A virtual space to reclaim emotional and spiritual equanimity">
	<script src="https://kit.fontawesome.com/0db8c7f53e.js" crossorigin="anonymous"></script>

	<link rel="shortcut icon" href="/images/logos/xxhdpi.png?v=ljaahIyaGhYt">
	
	@if(config('app.env') == 'production')
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-CLL0ND8JTF"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-CLL0ND8JTF');
		</script>
	@endif

	@yield('custom-head')
</head>
<body>
	
	@yield('content')
		
	@yield('custom-post-script')
</body>
</html>