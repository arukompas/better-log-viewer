<template>
    <div class="log-item" :class="[log.level_class]">
        <div @click="showStack = !showStack">
            <span class="log-level" :class="'text-' + log.level_class">{{ log.level }}</span>
            <span class="log-context text-muted">@ {{ log.context }}</span>
            <i class="log-date float-right">{{ log.date }}</i>
            <p>{{ log.text }}</p>
        </div>
        <pre class="log-stack" v-if="showStack">{{ log.stack }}</pre>
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
    background: white;
    padding: 7px 15px;
    border: 1px solid lightgrey;
    border-radius: 5px;
    margin: 5px 0px;
    transition: all 0.2s ease;
}

.log-item:hover {
    border-color: grey;
    cursor: pointer;
}

.log-item p {
    margin: 0px;
    word-break: break-word;
}

.log-item .log-stack {
    margin-top: 10px;
    overflow-x: auto;
    max-height: 700px;
    border: 1px dotted grey;
    cursor: auto;
}

.log-level {
    font-weight: bold;
    text-transform: uppercase;
}
</style>