/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import vuetify from './vuetify';
import router from './router';

import App from './components/AppComponent';
import Login from './components/LoginComponent';
import store from "./store";   
import VImageInput from 'vuetify-image-input';
import VueExpandableImage from 'vue-expandable-image'
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css"; 
const options = {
    transition: "Vue-Toastification__fade",
    maxToasts: 8,
    newestOnTop: true,
    filterBeforeCreate: (toast, toasts) => {
      if (toasts.filter(
        t => t.type === toast.type
      ).length !== 0) {
        // Returning false discards the toast
        return false;
      }
      // You can modify the toast if you want
      return toast;
    }
};


Vue.use(Toast, options);
Vue.use(VueExpandableImage)
Vue.component(VImageInput.name, VImageInput);
Vue.use(require("vue-moment"));  
new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components:{
        'app' : App
    }
});
