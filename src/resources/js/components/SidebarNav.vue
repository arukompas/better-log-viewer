<template>
    <nav id="sidebar" class="flex flex-col h-full py-5 mr-5">
        <div class="mx-3 mb-4">
            <h3 class="mb-0 text-xl font-thin">
                Better Log Viewer
                <spinner v-if="loading" class="ml-3"></spinner>

                <settings-control></settings-control>
            </h3>
            <span class="text-grey-darker">
                by <a href="https://www.github.com/arukompas/better-log-viewer" class="no-underline text-blue" target="_blank">@arukompas</a>
            </span>
        </div>

        <div class="overflow-y-scroll sidebar-contents">
            <log-file v-for="file in files" :key="file.name" :file="file" @delete="confirmFileDeletion(file)"></log-file>
        </div>
    </nav>
</template>

<script>
import SettingsControl from './SettingsControl';

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
            this.$bus.$emit('file-deleted', file);
        }
    },

    components: {
        SettingsControl,
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
.sidebar-contents {
    padding-bottom: 80px;
}
</style>
