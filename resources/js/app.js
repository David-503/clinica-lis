
/**
 * Carga librerías
 */





import Vue from 'vue';
import VueRouter from "vue-router";
import App from "./App.vue";

// router setup
import routes from "./routes/routes";

// plugins
import GlobalComponents from "./globalComponents";
import GlobalDirectives from "./globalDirectives";
import Notifications from "./components/NotificationPlugin";
import Vuelidate from "vuelidate"
import FullCalendar from 'vue-full-calendar'

// Material Dashboard Plugin
import MaterialDashboard from './material-dashboard';

import Chartist from 'chartist';

// configuracion del router
const router = new VueRouter({
    mode: 'history',
    routes,
    linkExactActiveClass: "nav-item active"
});

Vue.prototype.$Chartist = Chartist;

// Filtros
Vue.filter('age', function (value) {
    if (!value) return ''
    let now = new Date();
    let old = new Date(value);
    let diff =(now.getTime() - old.getTime()) / 1000;
    diff /= (60 * 60 * 24);
    return Math.abs(Math.round(diff/365.25));
})
  
import 'fullcalendar/dist/fullcalendar.css'

// Inserta plugins
Vue.use(VueRouter);
Vue.use(MaterialDashboard);
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.use(Notifications);
Vue.use(Vuelidate);
Vue.use(FullCalendar)

/**
 * Carga componentes
 */

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    data: {
        Chartist: Chartist
    }
});

// const side = new Vue({
//     el:'#side'
// });