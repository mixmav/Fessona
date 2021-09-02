<template>
	<div class="vRouterPage-home-page-container">
		<div class="main-page-content">
			<h1>Browse</h1>
			<div class="active-sites">
				<Flicking :options="{ circular: true }" :plugins="plugins">
					<div class="site">1</div>
					<div class="site">2</div>
					<div class="site">3</div>
					<div class="site">4</div>
					<div class="site">5</div>
					<div slot="viewport" class="flicking-pagination"></div>
				</Flicking>
			</div>
			<button class="btn full-width mt-20 blue" v-ripple><i class="fa fa-random"></i>Get a random message</button>
			<router-link to="/">Home</router-link>
		</div>
	</div>
</template>

<script>
import { Pagination } from "@egjs/flicking-plugins";

export default {
	data(){
		return {
			plugins: [new Pagination({ type: 'scroll' })],
		}
	}
}

</script>

<style lang="scss">

</style>
