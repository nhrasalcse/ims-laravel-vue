const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('stock-data?page=' + page);
    },
    createAPI(formData,header){
        return axios.post('stock-store',formData,header)
    },
   editAPI(id){
        return axios.get(`stock-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`stock-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('stock-update',formData,header)
    },
   searchAPI(formData,header){
        return axios.post('stock-search',formData,header)
    }

}