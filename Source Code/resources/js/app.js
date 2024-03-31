/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue')

import VueMoment from 'vue-moment'
Vue.use(VueMoment)

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import Swal from 'sweetalert2'
window.Swal = Swal;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Sweet Alert
 */
const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;

/**
 * Vue File Upload Component
 */
const VueUploadComponent = require('vue-upload-component');
Vue.component('file-upload', VueUploadComponent);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('group-chat', require('./components/GroupChat.vue').default);
Vue.component('private-chat', require('./components/PrivateChat.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);
Vue.component('notification-item', require('./components/NotificationItem.vue').default);
Vue.component('toast-component', require('./components/Toast.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


let elements = document.getElementsByClassName('vue')
for (let el of elements) {
    new Vue({
        el: el
    })
}

/**
 * Uncomment below when compiling to production
 */
Vue.config.productionTip = false
Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true

// const app = new Vue({
//     el: '#app'
// });

// import $ from "jquery";
// window.$ = window.jQuery = $;
