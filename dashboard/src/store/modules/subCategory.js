import subCategoryAPI from '../../api/subCategory';
const state={
    subCategory:[],
    activesubCategory: {
        id:null,
        category_id:null,
        name:null,
        description :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activesubCategory(state) {
        return state.activesubCategory;
    }
};
const actions= {
    getsubCategory({commit},page) {
        return new Promise((resolve, reject) => {
            subCategoryAPI.getAPI(page).then(response => {
                commit('setsubCategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getSubeCategory({commit}) {
        return new Promise((resolve, reject) => {
            subCategoryAPI.getCategoryAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createsubCategory({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return subCategoryAPI.createAPI(formData, header).then(response => {
                commit('setsubCategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updatesubCategory({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return subCategoryAPI.updateAPI(formData, header).then(response => {
                commit('updatesubCategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deletesubCategory({commit}, id) {
        return new Promise((resolve, reject) => {
        return subCategoryAPI.deleteAPI(id)
        .then(response => {
            commit('deletesubCategory', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editsubCategory({commit}, id) {
            return new Promise((resolve, reject) => {
            return subCategoryAPI.editAPI(id)
            .then(response => {
                commit('updatesubCategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setsubCategory(state, subCategory){
        state.subCategory=subCategory;
    },
    updatesubCategory(state, subCategory){
        state.subCategory=subCategory;
    },
    deletesubCategory(state, subCategory){
        state.subCategory=subCategory;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
