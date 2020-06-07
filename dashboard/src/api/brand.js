const axios = require('axios');
export default {
    getAPI(page) {
        return axios.get('brand-data?page=' + page);
    },
    getCategoryAPI() {
        return axios.get('category-data-brand');
    },
    getSubCategoryAPI() {
        return axios.get('subcategory-data-brand');
    },
    createAPI(formData,header){
        return axios.post('brand-store',formData,header)
    },
   editAPI(id){
        return axios.get(`brand-edit/${id}`)
    },
  findSubCategoryAPI(id){
        return axios.get(`brand-find-subcategory/${id}`)
    },
  deleteAPI(id){
        return axios.get(`brand-delete/${id}`)
    },
   updateAPI(formData,header){
        return axios.post('brand-update',formData,header)
    }

}