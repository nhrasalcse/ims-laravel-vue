const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('category-data?page=' + page);
    },
    createAPI(formData,header){
        return axios.post('category-store',formData,header)
    },
   editAPI(id){
        return axios.get(`category-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`category-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('category-update',formData,header)
    }

}