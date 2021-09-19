<template>
	<div class="vPage-component-active-site-panel-container">
		<div class="circles">
			<div></div>
			<div></div>
		</div>
	</div>
</template>

<script>

export default {
	mounted(){
	}
}
</script>


<style lang="scss">
	@import "../../../scss/variables";

	.vPage-component-active-site-panel-container{
		width: 80%;
		border-radius: 10px;
		height: 200px;
		margin-left: 10px;
		cursor: pointer;
		position: relative;
		background: $red;
		display: flex;
		justify-content: center;
		align-items: center;

		.circles{
			position: relative;
			
			div{
				width: 50px;
				height: 50px;
				border-radius: 100%;
				background: white;
				animation: breathe 2s linear infinite;
				
				&:nth-child(2){
					position: absolute;
					top: 0;
					left: 0;
					opacity: 0.6;
					animation: breathe 2s linear infinite;
					animation-delay: .5s;
				}
			}
		}
	}

	@keyframes breathe {
		from{
			transform: scale(1, 1);
		} 50%{
			transform: scale(1.4, 1.4);
		} to {
			transform: scale(1, 1);
		}
	}
</style>