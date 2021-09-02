<template>
	<div class="vRouterPage-home-page-container">
		<canvas id="bg"></canvas>
		<div class="content">
			<h1>Fessona</h1>
			<h2>Fessona, is a Roman Goddess Who aids the weary.</h2>
		</div>
	</div>
</template>

<script>
import * as THREE from 'three';
import $ from 'jquery';

export default {
	mounted(){
		this.scene = new THREE.Scene();
		this.camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

		this.renderer = new THREE.WebGLRenderer({
			canvas: document.querySelector('#bg')
		});

		this.resize();
		this.camera.position.setZ(30);


		const geometry = new THREE.TorusKnotGeometry(10,3,16,100);
		const material = new THREE.MeshPhongMaterial({color: 0xFF6347, wireframe: true});
		this.shape = new THREE.Mesh(geometry, material);

		this.scene.background = new THREE.TextureLoader().load('/images/bg.jpg');
		this.scene.add(this.shape);

		// this.light = new THREE.AmbientLight(0xffffff);
		// this.light.position.set(5,5,5);
		// this.scene.add(this.light);

		this.animate();

		$(window).resize(() => {
			this.resize();
		})
	},

	methods: {
		animate(){
			requestAnimationFrame(this.animate);
			this.shape.rotation.x += 0.01;
			this.shape.rotation.y += 0.005;
			this.shape.rotation.z += 0.01;
			this.renderer.render(this.scene, this.camera);
		},
		resize(){
			this.renderer.setPixelRatio(window.devicePixelRatio);
			this.renderer.setSize(window.innerWidth, window.innerHeight);

		}
	},
	data(){
		return {
			scene: {},
			camera: {},
			renderer: {},
			shape: {},
			light: {},

		}
	}
}

</script>

<style lang="scss">

@import "../../scss/variables";

.vRouterPage-home-page-container{
	canvas{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}

	.content{
		padding: 1em;
		position: relative;
	}
}

</style>