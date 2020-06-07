const axios = require('axios');
export default {
    Login(formData,header) {
        return axios.post('login',formData,header);
    },
    Me(headers) {
        return axios.get('me',headers);
    },
    Log_out(headers) {
        return axios.post('logout',headers);
    },

}
