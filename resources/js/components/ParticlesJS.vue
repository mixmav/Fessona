<template>
	<div :id="id" class="particles-js"></div>
</template>

<script>
import 'particles.js/particles';

export default {
	mounted(){
		this.particlesJS.load(this.id, '/assets/particles.json');
		this.addParticlesJSEventListener();
	},
	updated(){
		this.addParticlesJSEventListener();
	},

	data(){
		return {
			particlesJS: window.particlesJS,
		}
	},

	methods: {
		addParticlesJSEventListener(){
			// Wait for the child node to be rendered by giving it a timeout of 600ms
			// Then pass all mousemove events to the particles div
			setTimeout(() => {
				document.querySelector(this.container).addEventListener('mousemove', e => { 
					let customEvent = new MouseEvent('mousemove', {
						'screenX': e.screenX,
						'screenY': e.screenY,
						'clientX': e.clientX,
						'clientY': e.clientY
					});

					document.getElementById(this.id).childNodes[0].dispatchEvent(customEvent);
				});
			}, 600);
		},
	},

	props: {
		container: {
			type: String,
			default: '.main-page-content',
		},
		id: {
			type: String,
			default: 'particles-js-container'
		}
	}
}
</script>