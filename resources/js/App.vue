<template>
    <div class="main-app-container">
		<alert></alert>
        <div class="main-content">
			<div id="particles-js"></div>
			
			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
    </div>
</template>

<script>
import Alert from './components/Alert.vue';
import 'particles.js/particles';

export default {
	components: {
		Alert,
	},

    mounted() {
		this.particlesJS.load('particles-js', '/assets/particles.json');
		this.addParticlesJSEventListener();
    },

	updated(){
		this.addParticlesJSEventListener();
	},
    data() {
        return {
			particlesJS: window.particlesJS,
		};
    },
	methods: {
		addParticlesJSEventListener(){
			// Wait for the child node to be rendered by giving it a timeout of 600ms
			// Then pass all mousemove events to the particles div
			setTimeout(() => {
				document.querySelector('.main-page-content').addEventListener('mousemove', e => { 
					var e = document.createEvent('MouseEvents');
					e.initMouseEvent('mousemove',true,true,document.defaultView, 0, event.screenX, event.screenY, event.clientX, event.clientY,false,false,false,false,null,null);
					document.getElementById("particles-js").childNodes[0].dispatchEvent(e) 
				});
			}, 600);
		}
	}
};
</script>

<style lang="scss">
@import "../scss/variables";


.main-app-container {
    & > .main-content {
        padding: 1em;
		text-align: center;
		
		#particles-js{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 0;
		}
		.main-page-content{
			position: relative;
			z-index: $zIndex-router-content;
			width: 100%;
			max-width: 500px;
			text-align: left;
			display: inline-block;
		}
    }
}
</style>