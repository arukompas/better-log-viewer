<template>
    <div class="inline float-right">
        <dropdown class="inline" :close-on-click="false">
            <div slot="link">
                <i class="fa fa-cog text-grey pl-2 pr-1"></i>
            </div>
            <div slot="dropdown" class="bg-white shadow rounded border overflow-hidden text-base">
                <a href="" @click.prevent="toggleSetting('fullscreen')" class="no-underline block px-4 py-3 text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap hover:cursor-pointer">
                    <i class="mr-2" :class="{'fa fa-check-square': fullscreen, 'far fa-square': !fullscreen}"></i> Full screen
                </a>
                <a href="" @click.prevent="toggleSetting('shorterStackTraces')" class="no-underline block px-4 py-3 text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap hover:cursor-pointer">
                    <i class="mr-2" :class="{'fa fa-check-square': shorterStackTraces, 'far fa-square': !shorterStackTraces}"></i> Shorter Stack Traces
                </a>
            </div>
        </dropdown>
    </div>
</template>

<script>
import { settings, setSetting } from '../settings';

export default {
    name: 'SettingsControl',

    methods: {
        toggleSetting(name) {
            setSetting(name, !this[name]);
        },
    },

    computed: {
        fullscreen: () => settings.fullscreen,
        shorterStackTraces: () => settings.shorterStackTraces,
    }
}
</script>
