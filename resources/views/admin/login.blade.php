@extends('layout.master')

@section('title')
	Login
@endsection

@section('custom-head')
	<link rel="stylesheet" type="text/css" href="{{mix('/css/app.css')}}">
	<style>

		form{
			position: fixed;
			top: 50px;
			left: 50%;
			padding: 2em;
			border-radius: 10px;
			transform: translateX(-50%);
			width: 100%;
			max-width: 300px;
			background: white;
		}

		canvas#bg-canvas{
			display: block;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
	
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" integrity="sha512-z4OUqw38qNLpn1libAN9BsoDx6nbNFio5lA6CuTp9NlK83b89hgyCVq+N5FdBJptINztxn1Z3SaKSKUS5UP60Q==" crossorigin="anonymous"></script>
@endsection

@section('content')
		<canvas id="bg-canvas"></canvas>

		<form action="/admin/login" method="POST">
			<input type="text" class="text-input full-width" name="email" placeholder="Username" required autofocus>
			<input type="password" class="text-input full-width mt-10" placeholder="Super secret key" name="password" required>
			{{ csrf_field() }}
			<button type="submit" class="btn full-width mt-30"><i class="fa fa-seedling"></i>Let's go</button>
		</form>
		

@endsection

@section('custom-post-script')
		<script>
		const canvas = document.querySelector("#bg-canvas");
		const ctx = canvas.getContext("2d");
		const colors = [
		    "#b4b2b5",
		    "#dfd73f",
		    "#6ed2dc",
		    "#66cf5d",
		    "#c542cb",
		    "#d0535e",
		    "#3733c9"
		];
		let linePos = 0,
		    rAF;

		canvas.width = innerWidth;
		canvas.height = innerHeight;

		function texts(color) {
		    ctx.font = "20vh Bungee Outline";
		    ctx.shadowBlur = 30;
		    ctx.shadowColor = color;
		    ctx.fillStyle = color;
		    ctx.setTransform(1, -0.15, 0, 1, 0, -10);
		    ctx.fillText("Admin", innerWidth / 2, innerHeight / 2 - 5);

		    ctx.fillStyle = "white";
		    ctx.shadowBlur = 30;
		    ctx.shadowColor = color;
		    ctx.fillText("Admin", innerWidth / 2, innerHeight / 2);

		    ctx.font = "18vh Bungee Inline";
		    ctx.shadowBlur = 30;
		    ctx.shadowColor = color;
		    ctx.fillStyle = "#fff";
		    ctx.setTransform(1, -0.15, 0, 1, 0, -10);
		    ctx.fillText(
		        "Console",
		        innerWidth / 2,
		        innerHeight / 2 + innerHeight / 10
		    );

		    ctx.textAlign = "center";
		    ctx.textBaseline = "middle";
		}

		function glitch() {
		    rAF = window.requestAnimationFrame(glitch);

		    ctx.fillStyle = "#1a191c";
		    ctx.fillRect(0, 0, innerWidth, innerHeight);

		    texts(colors[Math.floor(Math.random() * 7)]);
		    ctx.shadowBlur = 0;
		    ctx.shadowColor = "none";
		    ctx.setTransform(1, 0, 0, 1, 0, 0);

		    for (let i = 0; i < 1000; i++) {
		        ctx.fillStyle = `rgba(255, 255, 255, ${Math.random() * 0.01})`;
		        ctx.fillRect(
		            Math.floor(Math.random() * innerWidth),
		            Math.floor(Math.random() * innerHeight),
		            Math.floor(Math.random() * 30) + 1,
		            Math.floor(Math.random() * 30) + 1
		        );

		        ctx.fillStyle = `rgba(0,0,0,${Math.random() * 0.1})`;
		        ctx.fillRect(
		            Math.floor(Math.random() * innerWidth),
		            Math.floor(Math.random() * innerHeight),
		            Math.floor(Math.random() * 25) + 1,
		            Math.floor(Math.random() * 25) + 1
		        );
		    }

		    ctx.fillStyle = colors[Math.floor(Math.random() * 40)];
		    ctx.fillRect(
		        Math.random() * innerWidth,
		        Math.random() * innerHeight,
		        Math.random() * innerWidth,
		        Math.random() * innerHeight
		    );
		    ctx.setTransform(1, 0, 0, .8, .2, 0);


		}

		glitch();

		window.addEventListener('resize', () => {
		    canvas.width = innerWidth;
		    canvas.height = innerHeight;
		});

		</script>
@endsection