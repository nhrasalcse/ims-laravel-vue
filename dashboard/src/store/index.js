import Vue from 'vue';
import Vuex from 'vuex';
import profile from './modules/profile';
import brand from './modules/brand';
import category from './modules/category';
import customer from './modules/customer';
import invoice from './modules/invoice';
import product from './modules/product';
import setting from './modules/setting';
import subCategory from './modules/subCategory';
import suplier from './modules/suplier';
import user from './modules/user';
import stock from './modules/stock';
import auth from './modules/auth'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';
export default new Vuex.Store({
    modules: {
        profile,
        auth,
        brand,
        category,
        customer,
        invoice,
        product ,
        setting ,
        subCategory ,
        suplier ,
        user ,
        stock,
    },
    strict: debug,
})
