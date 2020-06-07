const axios = require('axios');
export default {
    getData() {
        return axios.get('profile-data');
    },
   updateData(formData,header){
        return axios.post('profile-update',formData,header)
    },
   updatePassword(formData,header){
        return axios.post('profile-password-update',formData,header)
    }

}
