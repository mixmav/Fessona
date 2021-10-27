<template>
	<div class="vPage-component-share-answer-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		<transition name="translate-y-minus-100px" delay="300">

			<section class="container" v-show="visible">
				<div class="top-bar">
					<button v-ripple :disabled="isLoading" class="btn" :class="{darkBlack: !previewVisible, yellow: previewVisible}" @click="previewVisible ? previewVisible = false : toggleVisible(false)">
						<i class="fa fa-window-close" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Close</span>

						<i class="fa fa-arrow-left" v-show="previewVisible"></i>
						<span v-show="previewVisible">Edit</span>
					</button>

					<button v-ripple :disabled="isLoading" class="btn" :class="{darkBlack: previewVisible, primary: !previewVisible}" @click="topBarButtonTwoClick">
						<i class="fa fa-angle-double-right" v-show="!previewVisible"></i>
						<span v-show="!previewVisible">Preview</span>

						<i class="fa fa-paper-plane" v-show="previewVisible"></i>
						<span v-show="previewVisible">Submit</span>
					</button>
				</div>

				<div class="editor-content content custom-scrollbar" :class="{visible: !previewVisible}">
					<h2 class="question-prompt"># {{ question.prompt }}</h2>

					<quill-editor class="editor mt-30" v-model="content" :options="editorOption"></quill-editor>

					<div class="badges">
						<p>Confused? There really are no "right answers". How about</p>
						<div class="badge" v-for="(badge, key) in question.badges" :key="key">{{ badge }}</div>
					</div>
				</div>

				<div class="preview-content content ql-snow custom-scrollbar" :class="{visible: previewVisible}">
					<h1>This is what your balloon looks like</h1>

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
	},

	components: {
		quillEditor
	},

	data(){
		return {
			content: '',
			isLoading: false,
			previewVisible: false,
			editorOption: {
				placeholder: 'Anything at all',
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
						[{ 'list': 'bullet' }],
						[{ 'size': ['small', false, 'large', 'huge'] }],
						[{ 'font': [] }],
						[{ 'color': [] },],
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
					vThis.$toast.error('Error creating your balloon 🤐 Try again?');
				}
			});
		},

		topBarButtonTwoClick(){
			if (this.previewVisible) {
				this.publishLetter();
			} else {
				if(this.content.length <= 0){
					this.$toast.info("You can't create an empty balloon 🙄");
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
	@import "../../scss/variables";

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
			max-width: 600px;
			margin: 0 auto;
			background: white;
			overflow-y: visible;
			overflow-x: hidden;
			position: relative;
			border-radius: 5px;
			padding-bottom: 100px;

			& > .top-bar{
				width: 100%;
				height: 70px;
				max-width: 600px;
				position: fixed;
				top: 0;
				left: 50%;
				transform: translateX(-50%);
				padding: 1em;
				transition: all .2s;
				display: flex;
				justify-content: space-around;
				align-items: center;
				border-bottom: solid 1px rgba(black, 0.3);
				z-index: $zIndex-share-answer-dialog-top-bar;

				button{
					display: inline;
					width: 40%;
					max-width: 200px;
				}
			}
			& > .content{
				padding: 2em;
				position: absolute;
				z-index: $zIndex-share-answer-dialog-content;
				top: 70px;
				left: 0;
				width: 100%;
				transition: all .3s;
				overflow: auto;
				height: calc(100% - 70px);
				transform: translateX(-100%);
				&.visible{
					transform: translateX(0);
				}
			}
			& > .editor-content{
				.question-prompt{
					font-size: 1.4em;
				}
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
						&:nth-child(2){
							margin-left: 0;
						}
					}
				}
				.ql-container{
					min-height: inherit;
				}

				.editor{
					min-height: 200px;
				}
			}

			& > .preview-content{
				transform: translateX(100%);
				.ql-editor{
					height: auto;
				}
			}
		}
	}
</style>