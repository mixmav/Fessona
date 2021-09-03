<template>
	<div class="vRouterPage-browse-sites-page-container">
		<div class="main-page-content mt-60">
			<h1>Actve sites</h1>
			<div class="active-sites">
				<Flicking :plugins="plugins" :options="{inputType: ['touch', 'pointer', 'mouse']}">
					<div class="site" @click="sayHi">1</div>
					<div class="site" @click="sayHi">2</div>
					<div class="site" @click="sayHi">3</div>
					<div slot="viewport" class="flicking-pagination"></div>
				</Flicking>
			</div>
			<button class="btn full-width mt-30" v-ripple><i class="fa fa-random"></i>Get a random message</button>
			<router-link to="/" tag="button" class="btn darkBlack mt-20" v-ripple><i class="fa fa-igloo"></i>Back home</router-link>
		</div>
	</div>
</template>

<script>
import { Pagination } from "@egjs/flicking-plugins";

export default {
	data(){
		return {
			plugins: [new Pagination({ type: 'fraction' })],
		}
	},

	methods: {
		sayHi(){
			alert('hi')
		}
	}
}

</script>

<style lang="scss">
@import "../../scss/variables";

.vRouterPage-browse-sites-page-container{
	.flicking-pagination{
		position: relative;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		transform: none;
		margin: 10px auto;
		.flicking-pagination-bullet{
			width: 15px;
			height: 15px;
			&:hover{
				background: rgba($red, 0.6);
			}
		}
		.flicking-pagination-bullet-active{
			background: $red;
		}
	}

	.active-sites{
		margin-top: 10px;
		.site{
			width: 80%;
			border-radius: 10px;
			height: 200px;
			margin-left: 10px;
			cursor: pointer;
			background: $red;
			&:nth-child(even){
				background: $yellow;
			}
		}
	}
}

</style>
