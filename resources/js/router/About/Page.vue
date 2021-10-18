<template>
	<div class="vRouterPage-about-page-container">
		<div class="main-page-content">
			<h1>About</h1>
			<router-link to="/" class="a">Home</router-link>

			<h2 class="mt-30">What is Fessona?</h2>
			<p>Fessona was created as part of a commissioned artwork for RMIT creative.</p>
		</div>
	</div>
</template>

<script>

export default {

}

</script>

<style lang="scss">

@import "../../../scss/variables";

.vRouterPage-about-page-container{
	display: flex;
	justify-content: center;
	.main-page-content{
		max-width: 500px;
		position: relative !important;
	}

}

</style>