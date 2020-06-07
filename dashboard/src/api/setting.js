const axios = require('axios');
export default {
    getAPI() {
        return axios.get('settings-data');
    },
    createAPI(formData,header){
        return axios.post('settings-store',formData,header)
    },
   editAPI(id){
        return axios.get(`settings-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`settings-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('settings-update',formData,header)
    }

}