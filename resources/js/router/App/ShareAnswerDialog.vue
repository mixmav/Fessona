<template>
	<div class="vPage-component-share-answer-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		<transition name="translate-y-minus-100px" delay="300">

			<section class="container custom-scrollbar" v-show="visible" ref="scrollContainer">
				<div class="top-bar" :class="{'z-depth-1': scrolled}">
					
					<button v-ripple :disabled="isLoading" class="btn" :class="{red: !previewVisible, darkBlack: previewVisible}" @click="previewVisible ? previewVisible = false : toggleVisible(false)">
						<i class="fa fa-window-close" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Close dialog</span>

						<i class="fa fa-arrow-left" v-show="previewVisible"></i>
						<span v-show="previewVisible">Edit</span>
					</button>

					<button v-ripple :disabled="isLoading" class="btn" :class="{primary: previewVisible, darkBlack: !previewVisible}" @click="topBarButtonTwoClick">
						<i class="fa fa-angle-double-right" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Preview</span>

						<i class="fa fa-paper-plane" v-show="previewVisible"></i>
						<span v-show="previewVisible">Submit</span>
					</button>
				</div>

				<div class="editor-content content" :class="{visible: !previewVisible}">
					<h2><i class="far fa-bookmark"></i> {{ question.prompt }}</h2>
					
					<div class="badges">
						<p class="text-decor primary">Confused? You can share</p>
						<div class="badge" v-for="(badge, key) in question.badges" :key="key">{{ badge }}</div>
					</div>
					<div class="form mt-30">
						<div>
							<quill-editor class="editor" v-model="content" :options="editorOption"></quill-editor>
						</div>
					</div>
				</div>

				<div class="preview-content content ql-snow" :class="{visible: previewVisible}">
					<div class="top-bar">
						<h3>This is what your letter looks like</h3>
						<!-- <img class="profile-picture" :src="userProfilePictureFilePath" alt="Profile picture"> -->
					</div>
					
					<hr class="mt-10">
					<hr>
					<br>
					<br>
					<div class="preview ql-editor mt-20" v-html="content"></div>
				</div>
			</section>
		</transition>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import $ from 'jquery';

import Quill from 'quill';
import ImageCompress from 'quill-image-compress';
import { ImageDrop } from 'quill-image-drop-module';
import MagicUrl from 'quill-magic-url';
import BlotFormatter from "quill-blot-formatter";

Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageCompress', ImageCompress);
Quill.register('modules/magicUrl', MagicUrl)
Quill.register("modules/blotFormatter", BlotFormatter);

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import { quillEditor } from 'vue-quill-editor'

export default {
	created(){
		$(window).on({
			keydown: (event) => {
				if (this.visible && event.keyCode == 27) {
					this.toggleVisible(false);
				}
			},
		}, this.$refs.container);
	},

	beforeDestroy(){
		$(window).off('keydown', this.$refs.container);
		$(window).off('scroll', this.$refs.scrollContainer);
	},

	mounted(){
		var $containerRef = $(this.$refs.scrollContainer);
		$containerRef.on('scroll', (event) => {
			if ($containerRef.scrollTop() > 0){
				this.scrolled = true;
			} else {
				this.scrolled = false;
			}
		});

	},
	components: {
		quillEditor
	},

	data(){
		return {
			scrolled: false,
			content: '',
			isLoading: false,
			previewVisible: false,
			editorOption: {
				placeholder: 'Don\'t be shy',
				theme: 'snow',
				modules: {
					imageCompress: {
						quality: 0.3,
						maxWidth: 1000,
						maxHeight: 1000,
						debug: false,
					},
					blotFormatter: {},
					imageDrop: true,
					magicUrl: true,
					toolbar: [
						['bold', 'italic', 'underline'],
						[{ 'list': 'ordered' }, { 'list': 'bullet' }],
						[{ 'size': ['small', false, 'large', 'huge'] }],
						[{ 'font': [] }],
						[{ 'color': [] }, { 'background': [] }],
						[{ 'align': [] }],
						['image', 'video']
					],
				},
			},
		}
	},

	methods: {
		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				if (!this.isLoading) {
					this.toggleVisible(false);
				}
			}
		},

		...mapActions('ShareAnswerDialog', {
			toggleVisible: 'toggleVisible',
		}),

		publishLetter(){
			var vThis = this;
			$.ajax({
				url: '/api/model/balloon/create',
				method: 'POST',
				data: {
					questionID: vThis.question.id,
					content: vThis.content,
				},
				
				beforeSend(){
					vThis.isLoading = true;
				},

				success(response){
					vThis.content = '';
					vThis.previewVisible = false;
					vThis.toggleVisible(false);
					vThis.$toast.success('Your balloon is out in the wild 🎈');

					// TODO vThis.$parent.refreshLetters();
				},

				complete(){
					vThis.isLoading = false;
				},
				error(){
					vThis.$toast.error('There was an error creating your balloon, maybe try again?');
				}
			});
		},

		topBarButtonTwoClick(){
			if (this.previewVisible) {
				this.publishLetter();
			} else {
				if(this.content.length <= 0){
					this.$toast.error("You can't create an empty balloon 🙄");
				} else {
					this.previewVisible = true;
				}
			} 
		},
	},

	computed: {
		...mapState('ShareAnswerDialog', [
			'visible',
			'question'
		]),
	},
}
</script>

<style lang="scss">
	@import "../../../scss/variables";

	.vPage-component-share-answer-dialog-container{
		z-index: $zIndex-share-answer-dialog;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		display: flex;
		text-align: initial;
		background: rgba(black, 0.3);
		
		& > .container{
			width: 100%;
			height: 100%;
			// max-width: 800px;
			margin: 0 auto;
			background: white;
			overflow-y: auto;
			overflow-x: hidden;
			position: relative;
			padding-bottom: 100px;

			& > .top-bar{
				width: 100%;
				// max-width: 800px;
				position: fixed;
				z-index: $zIndex-share-answer-dialog-top-bar;
				top: 0;
				background: white;
				border-bottom-left-radius: 5px;
				border-bottom-right-radius: 5px;
				left: 50%;
				transform: translateX(-50%);
				padding: 1em;
				transition: all .2s;
				text-align: center;

				button{
					display: inline;
					width: 40%;
					max-width: 200px;
					&:nth-child(2){
						margin-left: 10px;
					}
				}
			}
			& > .content{
				padding: 2em {top: 0};
				position: absolute;
				z-index: $zIndex-share-answer-dialog-content;
				top: 100px;
				left: 0;
				width: 100%;
				border-radius: 5px;
				transition: all .3s;
				overflow: visible;
				transform: translateX(-100%);
				&.visible{
					transform: translateX(0);
				}
			}
			& > .editor-content{
				.badges{
					margin-top: 10px;
					// text-align: left;
					p{
						font-size: 1em;
						margin-bottom: 5px;
					}
					.badge{
						display: inline-block;
						margin-left: 3px;
						padding: 10px {
							top: 5px;
							bottom: 5px;
						};
						font-size: .8em;
						border-radius: 10px;
						background: darken(white, 5%);
						border: solid 1px darken(white, 10%);
						transition: all .2s;
						cursor: default;
						&:nth-child(2){
							margin-left: 0;
						}
						&:hover{
							background: $primary-color;
							color: white;
						}
					}
				}
				.form{
					.ql-container{
						min-height: inherit;
					}

					.editor{
						min-height: 200px;
					}
				}
			}

			& > .preview-content{
				transform: translateX(100%);
				& > .top-bar{
					// display: flex;
					// justify-content: space-between;
					// align-items: center;
					// .user-name{
						// font-weight: bold;
						// color: $green;
					// }

					// .profile-picture{
						// width: 70px;
						// height: 70px;
						// border-radius: 100%;
					// }
				}
			}
		}
	}

	// @include media-y(670px){
	// 	.vPage-component-share-answer-dialog-container{
	// 		& > .container{
	// 			margin-top: 0;
	// 			padding-bottom: 80px; // To be able to read content, offset the bottom bar's height
	// 			max-height: 100%;
	// 			border-radius: 0;
	// 		}

	// 		& > .bottom-bar{
	// 			top: initial;
	// 			bottom: 0;
	// 			border-radius: 0;
	// 		}
	// 	}
	// }
</style>