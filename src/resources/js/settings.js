
import Vue from 'vue';

function saveToStorage(value) {
    let storageKey = `better-log-viewer::settings`;
    window.localStorage.setItem(storageKey, JSON.stringify(value));
}

let storageKey = `better-log-viewer::settings`;
let loadedSettings = JSON.parse(window.localStorage.getItem(storageKey));

export const settings = Vue.observable({
    fullscreen: false,
    shorterStackTraces: false,
    perPage: 10,
    levelActive: {
        debug: true,
        info: true,
        notice: true,
        warning: true,
        error: true,
        critical: true,
        alert: true,
        emergency: true,
        processed: true,
        failed: true,
    },
    ...loadedSettings
});

export function setSetting(name, value) {
    Vue.set(settings, name, value);

    saveToStorage(settings);
}

export function setLevelActive(level, value) {
    Vue.set(settings.levelActive, level, value);

    saveToStorage(settings);
}
