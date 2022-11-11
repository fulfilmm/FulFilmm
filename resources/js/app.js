/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
Vue.config.devtools = false;
require('./bootstrap');

window.Vue = require('vue').default;


import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from './store';

import icons from './fontawesome'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add({ ...icons });
Vue.component('font-awesome-icon', FontAwesomeIcon)




Vue.component('car-component', require('./components/CarDashComponent.vue').default);
//Vue.component('car-maintain-component' , require('./components/CarMaintainComponent').default);
// Vue.component('car-record-componment', require('./components/CarRecordComponent.vue').default);
Vue.component('maintain-component', require('./components/MaintainComponent.vue').default);
Vue.component('invoice-component' , require('./components/invoice/InvoiceComponent.vue'). default);


import App from './components/AppComponent'
import CarList from './components/CarDashComponent';
import CarDetail from './components/CarDetailComponent'
import CarMaintain from './components/CarMaintainComponent';
import CarRecord from './components/CarRecordComponent';
import MaintainDetail from './components/MaintainDetailComponent'
import RecordDetail from './components/CarRecordDetailComponent';

import InvoiceDetail from './components/invoice/InvoiceDetailComponent';

const router = new VueRouter({
    mode: 'history',

    routes: [
        {
            path:'/car-list',
            name:'car-list',
            component: CarList,

        },

        {
            path:'/car-list/:id',
            name:'car-detail',
            component: CarDetail,
        },

        {
            path: '/car-list/car-maintain/:id',
            name: 'car-maintain',
            component: CarMaintain
        },

        {
            path: '/car-list/car-record/:id',
            name: 'car-record',
            component: CarRecord
        },

        {
            path:'/maintain/:id',
            name:'maintain-detail',
            component: MaintainDetail
        },

        {
            path:'/car-list/car-record/detail/:id',
            name: 'record-detail',
            component: RecordDetail
        },
        {
            path:'/invoice/:id',
            name: 'invoice-detail',
            component: InvoiceDetail
        }

    ],
});

const app = new Vue({
    el: '#app',
    components:{App},
    router,
    store
});