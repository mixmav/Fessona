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
			{{ ucfirst(config('app.name')) }} - 
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
	@yield('custom-head')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js" defer data-deferred="1"></script>

	<style>
		body{
			background: rgba(0,0,0,0.8);
		}
		.content{
			margin-top: 30px;
		}
		h1, p{
			color: white;
			text-align: center;
			position: relative;
			z-index: 1000;
		}
		
		#particles-js{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 0;
		}
	</style>
</head>
<body>
	<div id="particles-js"></div>
	
	<div class="content">
		@yield('content')
	</div>
	
	<script type="text/javascript">
		window.addEventListener('DOMContentLoaded', (event) => {
			particlesJS.load('particles-js', '/assets/particles.json');


			document.querySelector('.content').addEventListener('mousemove', e => { 
				let customEvent = new MouseEvent('mousemove', {
					'screenX': e.screenX,
					'screenY': e.screenY,
					'clientX': e.clientX,
					'clientY': e.clientY
				});

				document.getElementById("particles-js").childNodes[0].dispatchEvent(customEvent);
			});
		});
	</script>
	@yield('custom-post-script')
</body>
</html>