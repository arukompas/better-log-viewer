<template>
    <div class="log-file rounded p-3 m-2 hover:shadow-md flex justify-between items-center" @click="open" :class="{'bg-blue-light text-white': active, 'bg-white': !active}">
        <span class="no-underline log-file-name">{{ file.name }}</span>
        <div class="float-right ml-5 flex items-center">
            <small class="mr-3 text-grey-dark" :class="{'text-grey-lighter': active}">{{ file.size | fileSize }}</small>
            <dropdown>
                <div slot="link">
                    <i class="fa fa-ellipsis-v text-grey pl-2 pr-1" :class="{'text-grey-lighter': active}"></i>
                </div>
                <div slot="dropdown" class="bg-white shadow rounded border overflow-hidden">
                    <a :href="downloadLink" download class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap hover:cursor-pointer">
                        <i class="fa fa-download mr-2 text-grey"></i> Download
                    </a>
                    <a href="#" @click="$emit('delete')" class="no-underline block px-4 py-3 border-b text-red-light bg-white hover:text-white hover:bg-blue whitespace-no-wrap hover:cursor-pointer">
                        <i class="fa fa-trash mr-2 text-red-lighter"></i> Delete
                    </a>
                </div>
            </dropdown>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            required: true,
            type: Object,
        }
    },

    data() {
        return {
            active: false,
        }
    },

    mounted() {
        this.$root.event_bus.$on('file-changed', file => {
            this.active = file.name == this.file.name;
        });
    },

    methods: {
        open() {
            this.$root.event_bus.$emit('file-changed', this.file);
        }
    },

    computed: {
        downloadLink() {
            return `${window.route_path}api/file/${this.file.name}/download`;
        }
    }
}
</script>

<style>
.log-file {
    transition: all 0.2s ease;
}

.log-file:hover {
    cursor: pointer;
}
</style>
