import VueRouter from 'vue-router';
import App from "./components/App";
import Actions from "./components/Sections/Actions";
import Action from "./components/Sections/Action";
import Event from "./components/Sections/Event";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'Actions',
            component: Actions
        },
        {
            path: '/action/:action_id',
            name: 'Action',
            component: Action,
            props: true
        },
        {
            path: '/action/:action_id/event/:event_id',
            name: 'Event',
            component: Event,
            props: true
        }
    ],
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
