<template>
    <nav id="sidebar" class="flex flex-col h-full py-5 mr-5">
        <div class="mx-3 mb-4">
            <h3 class="mb-0 text-xl font-thin">
                Better Log Viewer
                <spinner v-if="loading" class="ml-3"></spinner>

                <span class="float-right ml-5 text-grey-dark hover:text-grey-darker cursor-pointer" @click="toggleFullscreen" title="Toggle fullscreen mode">
                    <i class="fa fa-expand-arrows-alt text-base" v-if="!fullscreen"></i>
                    <i class="fa fa-compress-arrows-alt text-base" v-if="fullscreen"></i>
                </span>
            </h3>
            <span class="text-grey-darker">
                by <a href="https://www.github.com/arukompas/better-log-viewer" class="no-underline text-blue" target="_blank">@arukompas</a>
            </span>
        </div>

        <div class="overflow-y-scroll">
            <log-file v-for="file in files" :key="file.name" :file="file" @delete="confirmFileDeletion(file)"></log-file>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            files: [],
            loading: false,
            fullscreen: false,
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
            this.fullscreen = !this.fullscreen;
            this.$root.event_bus.$emit('toggleFullscreen');
        },

        confirmFileDeletion(file) {
            swal({
                title: 'Are you sure?',
                text: `You're about to delete "${file.name}". Once deleted, you will not be able to recover this file!`,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((shouldDelete) => {
                if (shouldDelete) {
                    this.deleteFile(file);
                }
            });
        },

        deleteFile(file) {
            axios.delete(`${window.route_path}api/file/${file.name}`)
                .then(() => {
                    this.fileDeleted(file);
                }).catch(() => {
                    this.fileDeleted(file);
                });
        },

        fileDeleted(file) {
            let index = this.files.indexOf(file);
            this.files.splice(index, 1);
            swal(`"${file.name}" has been deleted`);
            this.$root.event_bus.$emit('file-deleted', file);
        }
    },
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
