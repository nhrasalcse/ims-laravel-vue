const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('customer-data?page=' + page);
    },
    getCustomerAPI(page) {
        return axios.get('invoice-customer-data');
    },
    getStockAPI(page) {
        return axios.get('invoice-stock-data');
    },
    findProductAPI(id) {
        return axios.get(`find-product-data/${id}`);
    },
    createAPI(formData,header){
        return axios.post('invoice-store',formData,header)
    },
   editAPI(id){
        return axios.get(`customer-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`customer-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('customer-update',formData,header)
    }

}