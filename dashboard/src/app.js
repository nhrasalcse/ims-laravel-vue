import Vue from "vue";
// import App from "./backendComponents/LoginComponent.vue";
import App from "./backendComponents/Layouts/BackendLayouts.vue";
import router from "./router";
import store from "./store";
import Toasted from 'vue-toasted';
Vue.config.productionTip = false;

Vue.use(Toasted, {
  duration: 1000
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
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
