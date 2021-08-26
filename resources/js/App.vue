<template>
    <div class="main-app-container">
        <div class="main-content">
			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
    </div>
</template>

<script>
export default {
    mounted() {
    },
    data() {
        return {};
    }
};
</script>

<style lang="scss">
@import "../scss/variables";
body {
    background: $black;
}

.main-app-container {
    & > .main-content {
        // padding: 1em;
    }
	.main-page-content{
		position: relative;
		z-index: $zIndex-router-content;
	}
}
</style>
