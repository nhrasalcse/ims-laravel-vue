const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('product-data?page=' + page);
    },
    getSupAPI() {
        return axios.get('suplier-product-data');
    },
    getBrandAPI() {
        return axios.get('product-brand-data');
    },
    createAPI(formData,header){
        return axios.post('product-store',formData,header)
    },
   editAPI(id){
        return axios.get(`product-edit/${id}`)
    },
    findBrandAPI(id){
        return axios.get(`product-find-brand/${id}`)
    },
  deleteAPI(id){
        return axios.get(`product-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('product-update',formData,header)
    }

}