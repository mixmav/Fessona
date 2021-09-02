<template>
    <div class="main-app-container">
		<alert></alert>
        <div class="main-content">
			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
    </div>
</template>

<script>
import Alert from './components/Alert.vue';

export default {
	components: {
		Alert,
	},

    mounted() {
    },
    data() {
        return {};
    }
};
</script>

<style lang="scss">
@import "../scss/variables";


.main-app-container {
    & > .main-content {
        padding: 1em;

		.main-page-content{
			position: relative;
			z-index: $zIndex-router-content;
			background: red;
		}
    }
}
</style>
