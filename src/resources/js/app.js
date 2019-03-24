require('./bootstrap');

window.Vue = require('vue');

import { directive as onClickaway } from 'vue-clickaway';
Vue.directive('onClickaway', onClickaway);

Vue.component('paginate', require('./components/Paginate.vue').default);
Vue.component('spinner', require('./components/Spinner.vue').default);
Vue.component('sidebar-nav', require('./components/SidebarNav.vue').default);
Vue.component('log-file', require('./components/LogFile.vue').default);
Vue.component('log-list', require('./components/LogList.vue').default);
Vue.component('log-item', require('./components/LogItem.vue').default);
Vue.component('app-layout', require('./components/AppLayout.vue').default);
Vue.component('btn', require('./components/Btn.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);

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
