import Vue from "vue";
// import App from "./backendComponents/LoginComponent.vue";
import App from "./backendComponents/Layouts/BackendLayouts.vue";
import router from "./router";
import store from "./store";
import Toasted from 'vue-toasted';
import axios from 'axios';
import $ from "jquery";
require('@/store/modules/subscriber')

axios.defaults.baseURL='http://localhost/inventory/api/public/api/v1/'

Vue.use(Toasted, {
  duration: 2000
})
router.beforeResolve((to, from, next) => {
    if (to.path) {
      NProgress.start()
    }
    next()
  });
  
  router.afterEach(() => {
    NProgress.done()
  })

Vue.config.productionTip = false;

store.dispatch('attempt',localStorage.getItem('token')).then(()=>{
  new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
})
