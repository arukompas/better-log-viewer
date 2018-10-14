<template>
    <div class="log-file p-2 m-2" @click="open" :class="{'active': active}">
        <span class="log-file-name">{{ file.name }}</span>
        <small class="float-right text-muted">{{ file.size | fileSize }}</small>
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
    }
}
</script>

<style>
.log-file {
    background: white;
    border: 1px solid white;
    border-radius: 5px;
    transition: all 0.2s ease;
}

.log-file:hover {
    cursor: pointer;
    box-shadow: 0px 0px 10px rgb(193, 222, 250);
}

.log-file-name {
    font-weight: bold;
}

.log-file-name:hover {
    text-decoration: underline;
}
</style>
