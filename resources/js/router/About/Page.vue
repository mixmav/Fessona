<template>
	<div class="vRouterPage-about-page-container custom-scrollbar">
		<div class="main-page-content">
			<h1>About</h1>
			<router-link to="/" class="a">Home</router-link>

			<h2 class="quickstart-heading-1" v-scroll-to="generateVueScrollToConfig('quickstart-heading-1')">What is Fessona?</h2>
			<p>Think of it as a virtual space designed to be an antidote to emotional fatigue. It's a lighthearted collection of crowdsourced good vibes.</p>
			
			<p>This project was developed as part of a commissioned artwork for RMIT creative by <a class="a" href="https://mixmav.me" target="_BLANK">Me</a>.<br> The name's "borrowed" from Roman mythology, where Fessona is thought to be the goddess that aids the weary.</p>


			<h2 class="quickstart-heading-3" v-scroll-to="generateVueScrollToConfig('quickstart-heading-3')">Background</h2>

			<p class="mt-10">As someone who journals regularly, I often write things addressed to 'future me'. I know there will be a day when I feel like shit. And there will also be a day when I feel like a fucking demigod.</p>
			<p class="mt-10">So I find that reading letters I wrote from a different headspace is an invaluable tool to cultivate some equanimity. Perhaps Fessona can help you do the same.</p>


			<h2 class="quickstart-heading-4" v-scroll-to="generateVueScrollToConfig('quickstart-heading-4')">Contact</h2>
			<p>If you found a bug or want to say hi, <a href="https://www.instagram.com/mav.ew/" class="a" target="_BLANK">instagram</a> or <a class="a" target="_BLANK" href="mailto:manav.sg1@gmail.com?subject=Fessona">email</a>.</p>

			<h2 class="quickstart-heading-5" v-scroll-to="generateVueScrollToConfig('quickstart-heading-5')">Support</h2>
			<p class="mt-10">I hope you found some interesting balloons that brought a smile on your face. However, Fessona is not art therapy, psychology or counselling. If you need support, here are some services available to you:</p>
			<ul class="mt-20">
				<li><a href="https://kidshelpline.com.au/" class="a" target="_BLANK">Kids Helpline</a>: 1800 55 1800</li>
				<li><a href="https://www.beyondblue.org.au/" class="a" target="_BLANK">Beyond Blue</a>: 1300 22 4636</li>
				<li><a href="https://www.lifeline.org.au/" class="a" target="_BLANK">Lifeline</a>: 13 11 14</li>
				<li><a href="https://www.rmit.edu.au/students/support-and-facilities/student-support/counselling" target="_BLANK" class="a">RMIT Student Support</a></li>
 				<li>RMIT Urgent Crisis Support (after hour call): 1300 305 737</li>
				<li>RMIT after hour text: 0488 884 162</li>
			</ul>

			<img src="/images/ssaf-logo.jpg" alt="SSAF Logo" class="ssaf-logo">
		</div>
	</div>
</template>

<script>

export default {
	methods: {
		generateVueScrollToConfig(id){
			return {
				el: '.' + id,
				container: 'body',
			}
		},
	}
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
		h2{
			margin-top: 30px;
			cursor: pointer;
		}
		.ssaf-logo{
			width: 100%;
			height: auto;
			display: block;
			max-width: 150px;
		}
	}

}

</style>