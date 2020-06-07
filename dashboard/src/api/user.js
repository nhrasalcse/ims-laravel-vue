const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('user-data?page=' + page);
    },
    getRoleAPI() {
        return axios.get('role-data');
    },
    createAPI(formData,header){
        return axios.post('user-store',formData,header)
    },
   editAPI(id){
        return axios.get(`user-edit/${id}`)
    },
  deleteAPI(id){
        return axios.get(`user-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('user-update',formData,header)
    }

}