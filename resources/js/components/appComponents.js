//Registered Components Vue JS
import Vue from "vue";

// window.Vue = require('vue/dist/vue.min.js');
window.Vue = require('vue/dist/vue.js');
/// Vue Scripts Sitу
Vue.config.devtools = true;
import store from './store/index';

//// Vue Router
import VueRouter from 'vue-router'
import onlineAppointmentTable from "./OnlineAppointment/OnlineAppointmentTable/OnlineAppointmentTable"

Vue.use(VueRouter)
const routes = [
    {
        path: '/',
        name: 'online-appointment',
        component: onlineAppointmentTable,
    },
    {
        path: '/:year',
        name: 'online-appointment-2',
        component: onlineAppointmentTable,
    },
    {
        path: '/:year/:month',
        name: 'online-appointment-3',
        component: onlineAppointmentTable,
    },


]
const router = new VueRouter({
    linkActiveClass: "active",
    linkExactActiveClass: "active",
    routes
})

$.holdReady(true)

document.addEventListener("DOMContentLoaded", () => {
    window.app = new Vue({
        router,
        store: store,
        mounted() {
            $.holdReady(false)
        },
        components: {

            //// Bike
            'tiny-mce': require('./TinyMce/TinyMce').default,
            'bike-form': require('./Bike/BikeForm/BikeForm').default,
            'modal-bike': require('./Bike/ModalBike/ModalBike').default,
            'bike-table': require('./Bike/BikeTable/BikeTable').default,

            ////Online Appointment
            'online-appointment-form': require('./OnlineAppointment/OnlineAppointmentForm/OnlineAppointmentForm').default,
            'online-appointment-table': require('./OnlineAppointment/OnlineAppointmentTable/OnlineAppointmentTable').default
        },

    }).$mount('#app');

});


console.log(Vue);

////// Хранилище состояний Vuex Store
///// Обращение к переменных Vuex в шаблонизаторе Blade $store.state.{название переменной}
window.vue2PanelDebug = true;
window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;



