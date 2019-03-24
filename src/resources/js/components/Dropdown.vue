<template>
    <div class="relative" v-on-clickaway="close">
        <div role="button" class="inline-block select-none" @click.prevent.stop="open = !open">
            <slot name="link"></slot>
        </div>
        <div class="absolute pin-r mt-px" style="z-index: 2;" v-show="open" @click.stop="close">
            <slot name="dropdown"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dropdown',
    data() {
        return {
            open: false,
        }
    },
    methods: {
        close() {
            this.open = false;
        }
    }
}
</script>
