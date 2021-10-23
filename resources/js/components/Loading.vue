<template>
	<div class="vLoading-component-container no-select">
		<div class="content-loader-ball-conatiner">
			<label>&nbsp;👽</label>
			<label>&nbsp;🌻</label>
			<label>&nbsp;🍄</label>
			<label>&nbsp;🍸</label>
			<label>&nbsp;🍺</label>
			<label>&nbsp;💮</label>
		</div>
	</div>
</template>

<style lang="scss">
	@import "../../scss/variables";

	.vLoading-component-container{
		opacity: 1;
		width: 100%;
		transition: all .3s ease 1s;
		overflow: hidden;
		.content-loader-ball-conatiner{
			label{
				@for $i from 1 through 6{
					$j: 600 - ($i*100);
					&:nth-child(#{$i}){
						animation: contentLoadAnim 2.5s #{$j}ms infinite ease-in-out;
					}
				}
			}
		}

		.content-loader-ball-conatiner{
			transform: translateY(-50%);
			top: 0;
			left: 50%;
			position: relative;
			color: $primary-color !important;
			pointer-events: none;
			text-align: center;
			transform: translateX(-50%);
			label{
				font-size: 20px;
				opacity: 0;
				color: inherit;
				display: inline-block;
				animation: none;
				i{
					color: inherit;
					font: {
						size: inherit;
					}
				}
			}
		}
	}

	@keyframes contentLoadAnim{
		0%{
			opacity: 0;
			transform: translateX(-300px);
		}
		33%{
			opacity: 1;
			transform: translateX(0px);
		}
		66%{
			opacity: 1;
			transform: translateX(0px);
		}
		100%{
			opacity: 0;
			transform: translateX(300px);
		}
	}
</style>