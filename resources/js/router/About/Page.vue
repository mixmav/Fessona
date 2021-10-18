<template>
	<div class="vRouterPage-about-page-container">
		<div class="main-page-content">
			<h1>About</h1>
			<router-link to="/" class="a">Home</router-link>

			<h2 class="mt-30">What is Fessona?</h2>
			<p class="mt-10">Fessona was created as part of a commissioned artwork for RMIT creative.</p>

			<h2 class="mt-30">Support</h2>
			<p class="mt-10">We hope Fessona brings you joy! However, this artwork/virtual realm is not designed to provide art therapy, psychology or counselling treatment. Here are some services available to you:</p>
			<ul class="mt-20">
				<li><a href="https://www.rmit.edu.au/students/support-and-facilities/student-support/counselling" target="_BLANK" class="a">RMIT Student Support</a></li>
				<li>Urgent Mental Health Support:</li>
				<li>Lifeline: 13 11 14</li>
 				<li>RMIT Urgent Crisis Support (after hour call): 1300 305 737</li>
				<li>RMIT after hour text: 0488 884 162</li>
				<li>Beyond Blue: 1300 22 4636</li>
			</ul>

			<h2 class="mt-30">SSAF logo also goes here, can't find it lol</h2>
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