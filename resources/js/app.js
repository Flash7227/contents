//Intro
require('./bootstrap');
window.Vue = require('vue');

//dependencies will place below
// import ViewUI from 'view-design';
// import locale from 'view-design/dist/locale/en-US';
// import 'view-design/dist/styles/iview.css';
// Vue.use(ViewUI, { locale });

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'

Vue.use(ElementUI, { locale })

window.moment = require('moment');

import CKEditor from '@ckeditor/ckeditor5-vue2';
Vue.use(CKEditor);

Vue.component('pagination', require('laravel-vue-pagination'));


//components will place below
Vue.component('upload-comp', require('./components/upload-comp.vue').default);
Vue.component('home-comp', require('./components/home-comp.vue').default);
Vue.component('shared-comp', require('./components/shared-comp.vue').default);
Vue.component('admin-comp', require('./components/admin-comp.vue').default);
Vue.component('profile-comp', require('./components/profile-comp.vue').default);




////attachments components
Vue.component('niitlel-comp', require('./components/niitlel-comp.vue').default);
Vue.component('poster-comp', require('./components/poster-comp.vue').default);
Vue.component('video-comp', require('./components/video-comp.vue').default);
Vue.component('file-comp', require('./components/file-comp.vue').default);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//frame
const app = new Vue({
    el: '#app',
});


if (process.env.MIX_APP_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}