const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('suplier-data?page=' + page);
    },
    createAPI(formData,header){
        return axios.post('suplier-store',formData,header)
    },
   editAPI(id){
        return axios.get(`suplier-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`suplier-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('suplier-update',formData,header)
    }

}