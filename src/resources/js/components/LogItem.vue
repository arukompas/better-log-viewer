<template>
    <div class="log-item" :class="[log.level_class]">
        <div @click="showStack = !showStack">
            <span class="log-level" :class="'text-' + log.level_class">{{ log.level }}</span>
            <span class="log-context text-muted">@ {{ log.context }}</span>
            <i class="log-date float-right">{{ log.date }}</i>
            <p>{{ log.text }}</p>
        </div>
        <pre class="log-stack p-2" v-if="showStack">{{ log.stack }}</pre>
    </div>
</template>

<script>
export default {
    props: {
        log: {
            required: true,
            type: Object
        }
    },

    data() {
        return {
            showStack: false
        }
    },

    mounted() {
        this.$root.event_bus.$on('page-changed', page => {
            this.showStack = false;
        });

        this.$root.event_bus.$on('file-changed', file => {
            this.showStack = false;
        });
    }
}
</script>

<style lang="scss">
.log-item {
    @apply .border .border-transparent .bg-white .mb-1 .p-3 .rounded;
}

.log-item:hover {
    @apply .cursor-pointer .border-grey;
}

.log-item.info {
    @apply .bg-blue-lightest;
}

.log-item.info:hover {
    @apply .border-blue-lighter;
}

.log-item.warning {
    @apply .bg-orange-lightest;
}

.log-item.warning:hover {
    @apply .border-orange-lighter;
}

.log-item.danger {
    @apply .bg-red-lightest;
}

.log-item.danger:hover {
    @apply .border-red-lighter;
}

.log-item p {
    margin: 0px;
    word-break: break-word;
}

.log-item .log-stack {
    overflow-x: auto;
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;
    white-space: -o-pre-wrap;
    word-wrap: break-word;
    margin-top: 10px;
    max-height: 700px;
    border: 1px dotted grey;
    cursor: auto;
    font-size: 12px;
}

.log-level {
    font-weight: bold;
    text-transform: uppercase;
}
</style>
