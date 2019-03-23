<template>
    <nav id="sidebar" class="sidebar-nav">
        <div class="mx-3 mb-4">
            <h3 class="mb-0">
                Better Log Viewer
                <spinner v-if="loading" class="ml-3"></spinner>

                <span class="float-right" @click="toggleFullscreen" title="Toggle fullscreen mode">
                    <icon-expand></icon-expand>
                </span>
            </h3>
            <span class="text-muted"> by <a href="https://www.github.com/arukompas/better-log-viewer" target="_blank">@arukompas</a></span>
        </div>

        <log-file v-for="file in files" :key="file.name" :file="file"></log-file>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            files: [],
            loading: false,
        }
    },

    mounted() {
        this.getFiles();
    },

    methods: {
        getFiles() {
            var vm = this;
            this.loading = true;
            axios.get(`${window.route_path}api/files`)
                .then(({data}) => {
                    this.loading = false;
                    this.files = data;
                    vm.$snotify.success('List of files loaded!');
                }).catch(error => {
                    this.loading = false;
                });
        },

        toggleFullscreen() {
            console.log('here');
            this.$root.event_bus.$emit('toggleFullscreen');
        }
    }
}
</script>

<style>
.log-file {
    margin-bottom: 5px;
}
.badge {
    margin-right: 5px;
    margin-bottom: 5px;
}
.log-file p {
    margin: 0px;
}
</style>
