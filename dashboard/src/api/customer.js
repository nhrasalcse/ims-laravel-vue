const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('customer-data?page=' + page);
    },
    createAPI(formData,header){
        return axios.post('customer-store',formData,header)
    },
   editAPI(id){
        return axios.get(`customer-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`customer-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('customer-update',formData,header)
    },
   searchAPI(formData,header){
        return axios.post('customer-search',formData,header)
    }

}