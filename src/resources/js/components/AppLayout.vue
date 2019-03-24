<template>
    <div :class="{'container mx-auto': !fullscreen, 'px-5': fullscreen}">
        <div class="flex max-h-screen">
            <div class="flex-no-shrink max-h-screen">
                <sidebar-nav></sidebar-nav>
            </div>
            <div class="flex-auto max-h-screen">
                <log-list></log-list>
            </div>
        </div>
        <vue-snotify></vue-snotify>
    </div>
</template>

<script>
export default {
    name: 'AppLayout',

    data() {
        return {
            fullscreen: false,
        };
    },

    mounted() {
        this.$root.event_bus.$on('toggleFullscreen', () => {
            this.fullscreen = !this.fullscreen;
        });
    }
}
</script>
