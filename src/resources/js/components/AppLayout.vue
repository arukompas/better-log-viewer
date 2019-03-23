<template>
    <div :class="{'container': !fullscreen, 'container-fluid': fullscreen}">
        <div class="row">
            <div :class="{'col-lg-4 col-md-5 col-sm-6 col-xs-12': !fullscreen, 'col-lg-3 col-md-4 col-sm-6 col-xs-12': fullscreen}">
                <sidebar-nav></sidebar-nav>
            </div>
            <div :class="{'col-lg-8 col-md-7 col-sm-6 col-xs-12': !fullscreen, 'col-lg-9 col-md-8 col-sm-6 col-xs-12': fullscreen}">
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
