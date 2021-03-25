import Vue from "vue"
import Vuex from "vuex"
import currentUser from "./modules/currentUser"
import user from "./modules/user"
Vue.use(Vuex);
import { createFlashStore } from 'vuex-flash';
export default new Vuex.Store({
    modules: {
        currentUser,
        user
    },
    state: {
        error: ""
      }
})
const store = new Vuex.Store({
    // ...
    plugins: [
      createFlashStore()
    ]
  });