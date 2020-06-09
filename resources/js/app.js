/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Authorization from './authorization/authorize';
import router from './router';
 
Vue.use(VueIziToast);
Vue.use(Authorization);

// Vue.component('question-page', require('./pages/QuestionPage.vue').default);
Vue.component('spinner', require('./components/Spinner.vue').default);

const app = new Vue({
    el: '#app',

    data() {
        return {
            loading: false
        }
    },

    created () {
        axios.interceptors.request.use((config) => {
            this.loading = true
            return config;
        }, (error) => {
            this.loading = false
            return Promise.reject(error);
        });

        axios.interceptors.response.use((response) => {
            this.loading = false
            return response;
        }, (error) => {
            this.loading = false
            return Promise.reject(error);
        });
    },

    router
});
