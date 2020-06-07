const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('sub-category-data?page=' + page);
    },
    getCategoryAPI() {
        return axios.get('category-data-sub');
    },
    createAPI(formData,header){
        return axios.post('sub-category-store',formData,header)
    },
   editAPI(id){
        return axios.get(`sub-category-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`sub-category-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('sub-category-update',formData,header)
    }

}