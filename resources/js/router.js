import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import CarDetail from './components/CarDetailComponent';
import Example from './components/ExampleComponent';




const  routes = [

        {
            path: 'car-list/:id',
            name: 'car.show',
            component: CarDetail
        },

        {
            path:'/vue/example',
            name:'Example',
            component: Example
        }

    ];

    const router = new VueRouter({

        routes,
        mode: 'history',
        hasband: false,
    });

export default new VueRouter ([
    router
    
])