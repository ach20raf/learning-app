require('./bootstrap');

require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);

const app = document.getElementById('app');
window.notifications = [];
window.notified = false;
window.Pusher = require('./pusher.min.js');
window.eventBus = new Vue();
Pusher.logToConsole = false;

var pusher = new Pusher('edd223a9b1cb4715f3fd', {
    cluster: 'eu'
});

var channel = pusher.subscribe('my-channel');
channel.bind('new-course-event', function (data) {
    window.notifications.push(data);
    window.notified = true;
});


new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
            data: {
                notifications: window.notifications,
            },
            mounted() {
                console.log(this.notifications);
            }
        }),
}).$mount(app);
