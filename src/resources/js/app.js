require('./bootstrap');

window.Vue = require('vue');

Vue.component('paginate', require('./components/Paginate.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));
Vue.component('sidebar-nav', require('./components/SidebarNav.vue'));
Vue.component('log-file', require('./components/LogFile.vue'));
Vue.component('log-list', require('./components/LogList.vue'));
Vue.component('log-item', require('./components/LogItem.vue'));
Vue.component('app-layout', require('./components/AppLayout.vue'));

Vue.component('icon-expand', require('./components/icons/IconExpand.vue'));

Vue.filter('fileSize', function (size) {
    if (size > 1024 * 1024 * 1024) {
        return Math.round((size / (1024 * 1024 * 1024)) * 100) / 100 + ' GB';
    } else if (size > 1024 * 1024) {
        return Math.round((size / (1024 * 1024)) * 100) / 100 + ' MB';
    } else if (size > 1024) {
        return Math.round((size / 1024) * 100) / 100 + ' KB';
    } else {
        return size + ' B';
    }
});

import Snotify from 'vue-snotify'
Vue.use(Snotify);

const event_bus = new Vue({});

const app = new Vue({
    data: {
        event_bus: event_bus
    }
});

window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response.data.message) {
        app.$snotify.error(error.response.data.message);
    }
    return Promise.reject(error);
});

app.$mount('#app');
