require('./bootstrap');

window.Vue = require('vue');
import ViewUI from 'view-design';
import locale from 'view-design/dist/locale/en-US';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI, { locale });

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
});
