/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
//import router from './router.js';
//import router from 'vue-router' 

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import icons from './fontawesome'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add({ ...icons });
Vue.component('font-awesome-icon', FontAwesomeIcon)

 


Vue.component('car-component', require('./components/CarDashComponent.vue').default);
Vue.component('maintain-component', require('./components/MaintainComponent.vue').default);


import App from './components/AppComponent'
import CarDetail from './components/CarDetailComponent'
import MaintainDetail from './components/MaintainDetailComponent'

const router = new VueRouter({
    mode: 'history',

    routes: [

        {
            path:'/car-list/:id',
            name:'car-detail',
            component: CarDetail,
        },

        {
            path:'/maintain/:id',
            name:'maintain-detail',
            component: MaintainDetail
        }

    ],
});

const app = new Vue({
    el: '#app',
    components:{App},
    router,
    
})
