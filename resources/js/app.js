//Intro
require('./bootstrap');
window.Vue = require('vue');

//dependencies will place below
import ViewUI from 'view-design';
import locale from 'view-design/dist/locale/en-US';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI, { locale });

window.moment = require('moment'); 



//components will place below
Vue.component('navbar-comp', require('./components/navbar.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


//frame
const app = new Vue({
    el: '#app',
});
