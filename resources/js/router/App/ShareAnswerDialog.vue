<template>
	<div class="vPage-component-share-answer-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		<transition name="translate-y-minus-100px" delay="300">

			<section class="container custom-scrollbar" v-show="visible" ref="scrollContainer">
				<div class="top-bar" :class="{'z-depth-1': scrolled}">
					
					<button v-ripple :disabled="isLoading" class="btn jumbo" :class="{red: !previewVisible, blue: previewVisible}" @click="previewVisible ? previewVisible = false : toggleVisible(false)">
						<i class="fa fa-window-close" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Close dialog</span>

						<i class="fa fa-arrow-left" v-show="previewVisible"></i>
						<span v-show="previewVisible">Edit</span>
					</button>

					<button v-ripple :disabled="isLoading" class="btn jumbo" :class="{green: previewVisible, blue: !previewVisible}" @click="topBarButtonTwoClick">
						<i class="fa fa-angle-double-right" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Preview</span>

						<i class="fa fa-paper-plane" v-show="previewVisible"></i>
						<span v-show="previewVisible">Submit</span>
					</button>
				</div>

				<div class="editor-content content" :class="{visible: !previewVisible}">
					<h2>Curate your balloon 🎈</h2>
					<div class="form mt-30">
						<input v-model="title" type="text" class="title-input" placeholder="Title or subject" ref="titleInput">
						
						<div class="mt-30">
							<quill-editor class="editor" v-model="content" :options="editorOption"></quill-editor>
						</div>
					</div>
				</div>

				<div class="preview-content content ql-snow" :class="{visible: previewVisible}">
					<!-- <h3>This is what your letter looks like</h3> -->
					<div class="title-bar">
						<div>
							<h1>{{ title }}</h1>
							<!-- <p class="mt-20">Written by <span class="user-name">{{ user.name }}</span></p> -->
						</div>

						<!-- <img class="profile-picture" :src="userProfilePictureFilePath" alt="Profile picture"> -->
					</div>
					
					<hr class="mt-10">
					<div class="preview ql-editor mt-20" v-html="content"></div>
				</div>
			</section>
		</transition>
	</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import $ from 'jquery';

import Quill from 'quill';
import ImageCompress from 'quill-image-compress';
Quill.register('modules/imageCompress', ImageCompress);

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

		this.$refs.titleInput.focus();
	},
	watch: {
		visible(newState, oldState) {
			if (newState) {
				setTimeout(() => {
					this.$refs.titleInput.focus();
				}, 300)
			}
		}
	},
	components: {
		quillEditor
	},

	data(){
		return {
			scrolled: false,
			title: '',
			content: '',
			isLoading: false,
			previewVisible: false,
			editorOption: {
				placeholder: 'Hey hey, ho ho, not writing a letter has got to go',
				modules: {
					imageCompress: {
						quality: 0.3,
						maxWidth: 1000,
						maxHeight: 1000,
						debug: false,
					},
					toolbar: [
						['bold', 'italic', 'underline', 'strike'],
						['blockquote', 'code-block'],
						[{ 'header': 1 }, { 'header': 2 }],
						[{ 'list': 'ordered' }, { 'list': 'bullet' }],
						[{ 'script': 'sub' }, { 'script': 'super' }],
						[{ 'indent': '-1' }, { 'indent': '+1' }],
						[{ 'direction': 'rtl' }],
						[{ 'size': ['small', false, 'large', 'huge'] }],
						[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
						[{ 'font': [] }],
						[{ 'color': [] }, { 'background': [] }],
						[{ 'align': [] }],
						['clean'],
						['link', 'image', 'video']
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
				url: '/api/auth/model/letter/create',
				method: 'POST',
				data: {
					title: vThis.title,
					content: vThis.content,
				},
				
				beforeSend(){
					vThis.isLoading = true;
				},

				success(response){
					vThis.title = '';
					vThis.content = '';
					vThis.previewVisible = false;
					vThis.toggleVisible(false);
					vThis.$parent.refreshLetters();
				},

				complete(){
					vThis.isLoading = false;
				},
				error(){
					alert('There was an error submitting your balloon :(');
				}
			});
		},

		topBarButtonTwoClick(){
			if (this.previewVisible) {
				this.publishLetter();
			} else {
				if (this.title.length <= 0) {
					alert("The title can't be empty :(");
				} else if(this.content.length <= 0){
					alert("The letter contents can't be empty :(");
				} else {
					this.previewVisible = true;
				}
			} 
		},
	},

	computed: {
		...mapState('ShareAnswerDialog', [
			'visible',
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

			.top-bar{
				width: 100%;
				max-width: 800px;
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
				.form{
					.title-input{
						padding: 1em;
						width: 100%;
						letter-spacing: 1px;
					}
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

				& > .title-bar{
					display: flex;
					justify-content: space-between;
					align-items: center;
					.user-name{
						font-weight: bold;
						color: $green;
					}

					.profile-picture{
						width: 70px;
						height: 70px;
						border-radius: 100%;
					}
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