<template>
	<div class="vRouterPage-browse-sites-page-container">
		<div class="main-page-content mt-60">
			<h1>Actve sites</h1>
			<p>Each box below represents a real location at an RMIT Campus filled with community-generated content.</p>
			<p class="mt-10">Pick one to leave your own! <i class="fa fa-hand-point-down"></i></p>
			<div class="active-sites">
				<loading v-show="sitesLoading"></loading>
				<Flicking ref="flicking" :plugins="plugins" :options="options" @visible-change="triggerVisibleChange">
					<active-site-panel v-for="site in sites" :key="site.id"></active-site-panel>
					
					<div slot="viewport" class="flicking-pagination"></div>
				</Flicking>
			</div>
			<button class="btn full-width mt-30" v-ripple><i class="fa fa-random"></i>Read	 a random scribble</button>
			
			<router-link to="/" class="btn darkBlack mt-20" v-ripple><i class="fa fa-igloo"></i>Back home</router-link>
		</div>
	</div>
</template>

<script>
import { Pagination } from "@egjs/flicking-plugins";
import { Flicking } from "@egjs/vue-flicking";
import * as Tone from 'tone'
import { mapActions } from 'vuex';
import $ from 'jquery';

import ActiveSitePanel from './ActiveSitePanel.vue';
import Loading from '../../components/Loading.vue';



export default {
	data(){
		return {
			plugins: [new Pagination({ type: 'bullet' })],
			options: {
				inputType: ['touch', 'pointer', 'mouse'],
				interruptable: true,
				align: 'prev',
				autoInit: false,
			},

			sitesLoading: false,
			sites: [],
		}
	},
	
	components: {
		Flicking,
		ActiveSitePanel,
		Loading,
	},

	mounted(){
		let vThis = this;
		$.ajax({
			url: '/api/sites/get-active-sites',
			beforeSend(){
				vThis.sitesLoading = true;
			},
			error(){
				vThis.showAlert({
					message: 'Unable to fetch sites; please try again 😣'
				});
			},
			complete(){
				vThis.sitesLoading = false;
			},
			success(data){
				if (data) {
					vThis.sites = data;
					vThis.$refs.flicking.init();
				}
			}
		})
	},

	methods: {
		triggerVisibleChange(event){
			console.log(event);
			const synth = new Tone.Synth().toDestination();
			synth.triggerAttackRelease("C4", "8n");
		},

		...mapActions('Alert', [
			'showAlert'
		])
	}
}

</script>

<style lang="scss">
@import "../../../scss/variables";

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
			// &:nth-child(even){
			// 	background: $yellow;
			// }
		}
	}
}

</style>
