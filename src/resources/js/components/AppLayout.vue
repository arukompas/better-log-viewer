<template>
    <div :class="{'container mx-auto': !fullscreen, 'px-5': fullscreen}">
        <div class="flex max-h-screen">
            <div class="flex-no-shrink min-h-screen max-h-screen">
                <sidebar-nav></sidebar-nav>
            </div>
            <div class="flex-auto max-h-screen">
                <log-list></log-list>
            </div>
        </div>
        <vue-snotify></vue-snotify>
    </div>
</template>

<script>
import { settings } from '../settings';

export default {
    name: 'AppLayout',

    computed: {
        fullscreen: () => settings.fullscreen,
    }
}
</script>
