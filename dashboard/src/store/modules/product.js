import productAPI from '../../api/product';
const state={
    product:[],
    activeproduct: {
        id:null,
        category_id:null,
        product_qr_bar_code:null,
        sub_category_id:null,
        brand_id:null,
        name:null,
        description :null,
        colour :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeproduct(state) {
        return state.activeproduct;
    }
};
const actions= {
    getProduct({commit},page) {
        return new Promise((resolve, reject) => {
            productAPI.getAPI(page).then(response => {
                commit('setproduct', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getProductSup({commit},page) {
        return new Promise((resolve, reject) => {
            productAPI.getSupAPI(page).then(response => {
                commit('setproduct', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getBrandData({commit}) {
        return new Promise((resolve, reject) => {
            productAPI.getBrandAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createProduct({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return productAPI.createAPI(formData, header).then(response => {
                commit('setproduct', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateProduct({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return productAPI.updateAPI(formData, header).then(response => {
                commit('updateproduct', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteProduct({commit}, id) {
        return new Promise((resolve, reject) => {
        return productAPI.deleteAPI(id)
        .then(response => {
            commit('deleteproduct', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editProduct({commit}, id) {
            return new Promise((resolve, reject) => {
            return productAPI.editAPI(id)
            .then(response => {
                commit('updateproduct', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    
    findBrand({commit}, id) {
        return new Promise((resolve, reject) => {
        return productAPI.findBrandAPI(id)
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
    setproduct(state, product){
        state.product=product;
    },
    updateproduct(state, product){
        state.product=product;
    },
    deleteproduct(state, product){
        state.product=product;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
