<template>
    <div class="relative" v-on-clickaway="close">
        <div role="button" class="inline-block select-none" @click.prevent.stop="open = !open">
            <slot name="link"></slot>
        </div>
        <div class="absolute pin-r mt-px" style="z-index: 2;" v-show="open" @click.stop="buttonClicked">
            <slot name="dropdown"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dropdown',

    props: {
        closeOnClick: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            open: false,
        }
    },

    methods: {
        buttonClicked() {
            if (this.closeOnClick) {
                this.close();
            }
        },

        close() {
            this.open = false;
        }
    }
}
</script>
