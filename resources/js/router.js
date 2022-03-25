import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import CarDetail from './components/CarDetailComponent';
import CarMaintain from './components/CarDetailComponent';
import CarRecord from './components/CarRecordComponent';
//import Example from './components/ExampleComponent';




const  routes = [

        {
            path: 'car-list/:id',
            name: 'car.show',
            component: CarDetail
        },

        {
            path: 'car-list/car-maintain/:id',
            name: 'car.maintain',
            component: CarMaintain
        },

        {
            path: 'car-list/car-record/:id',
            name: 'car.record',
            component: CarRecord
        },

        // {
        //     path:'car-record/:id',
        //     name:'Example',
        //     component: Example
        // }

    ];

    const router = new VueRouter({

        routes,
        mode: 'history',
        hasband: false,
    });

export default new VueRouter ([
    router
    
])