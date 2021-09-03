<!--

	 __  __                                                                             _                              
|  \/  |  __ _    _ _     __ _    __ __     o O O __ __ __ __ _     ___      o O O | |_      ___      _ _    ___   
| |\/| | / _` |  | ' \   / _` |   \ V /    o      \ V  V // _` |   (_-<     o      | ' \    / -_)    | '_|  / -_)  
|_|__|_| \__,_|  |_||_|  \__,_|   _\_/_   TS__[O]  \_/\_/ \__,_|   /__/_   TS__[O] |_||_|   \___|   _|_|_   \___|  
_|"""""|_|"""""|_|"""""|_|"""""|_|"""""| {======|_|"""""|_|"""""|_|"""""| {======|_|"""""|_|"""""|_|"""""|_|"""""| 
"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'./o--000'"`-0-0-'"`-0-0-'"`-0-0-'./o--000'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-' 

-->

<!DOCTYPE html>
<html lang="en">
<head>

	@if(config('app.env') == 'production')
		{{-- Analytics --}}
	@endif

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

	<script src="https://kit.fontawesome.com/0db8c7f53e.js" crossorigin="anonymous"></script>

	<link rel="shortcut icon" href="/images/logos/xhdpi.png?v=ljaahIyaGhYt">
	
	@yield('custom-head')
</head>
<body>
	
	<div id="content-container">
		@yield('content')
	</div>
		
	@yield('custom-post-script')
</body>
</html>