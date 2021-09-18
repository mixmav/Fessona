<template>
	<div class="vRouterPage-home-page-container">
		
		<transition name="opacity">
			<quickstart ref="homePageQuickstart" v-show="quickstartDialogVisible"></quickstart>
		</transition>


		<div class="main-page-content">
			<h1>Fessona</h1>
			<p style="font-size: 1em">/fə'səunə/</p>
			<p class="mt-10">In Roman mythology, Fessona is thought to be the goddess that cures fatigue 🎈</p>
			
			<button class="btn mt-20" v-ripple v-tooltip.left="'Quickstart'" @click="showQuickstart"><i class="fa fa-info-circle"></i>How it works</button>
			
			&nbsp;
			<router-link class="btn darkBlack mt-20" to="/sites" v-ripple><i class="fa fa-play-circle"></i>Launch</router-link>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import Quickstart from './Quickstart.vue';


export default {
	components: {
		Quickstart,
	},

	mounted(){
		setTimeout(() => {
			this.showQuickstart();
		}, 1000);
	},
	
	methods: {
		showQuickstart(){
			this.toggleQuickstartDialogVisible(true);
		},
		
		...mapActions('Alert', [
			'showAlert',
		]),
		
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),
	},

	computed: {
		...mapState('QuickstartDialog', {
			quickstartDialogVisible: 'visible'
		})
	}
}

</script>

<style lang="scss">

@import "../../../scss/variables";

.vRouterPage-home-page-container{
	display: flex;
	justify-content: center;
	.main-page-content{
		max-width: 500px;
		margin-top: 100px;
		position: relative !important;
	}
}
</style>