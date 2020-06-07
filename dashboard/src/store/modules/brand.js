import brandAPI from '../../api/brand';
const state={
    brand:[],
    activeBrand: {
        id:null,
        category_id:null,
        sub_category_id:null,
        name:null,
        description :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeBrand(state) {
        return state.activeBrand;
    }
};
const actions= {
    getBrand({commit},page) {
        return new Promise((resolve, reject) => {
            brandAPI.getAPI(page).then(response => {
                commit('setBrand', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    
    getBrandCategory({commit}) {
        return new Promise((resolve, reject) => {
            brandAPI.getCategoryAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    
    getSubCategory({commit}) {
        return new Promise((resolve, reject) => {
            brandAPI.getSubCategoryAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createBrand({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return brandAPI.createAPI(formData, header).then(response => {
                commit('setBrand', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateBrand({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return brandAPI.updateAPI(formData, header).then(response => {
                commit('updateBrand', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteBrand({commit}, id) {
        return new Promise((resolve, reject) => {
        return brandAPI.deleteAPI(id)
        .then(response => {
            commit('deleteBrand', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
editBrand({commit}, id) {
            return new Promise((resolve, reject) => {
            return brandAPI.editAPI(id)
            .then(response => {
                commit('updateBrand', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    findSubCategory({commit}, id) {
            return new Promise((resolve, reject) => {
            return brandAPI.findSubCategoryAPI(id)
            .then(response => {
                commit('updateBrand', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setBrand(state, brand){
        state.brand=brand;
    },
    updateBrand(state, brand){
        state.brand=brand;
    },
    deleteBrand(state, brand){
        state.brand=brand;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
