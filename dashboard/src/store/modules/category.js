import categoryAPI from '../../api/category';
const state={
    category:[],
    activeCategory: {
        id:null,
        name:null,
        description :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeCategory(state) {
        return state.activeCategory;
    }
};
const actions= {
    getCategory({commit},page) {
        return new Promise((resolve, reject) => {
            categoryAPI.getAPI(page).then(response => {
                commit('setcategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createCategory({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return categoryAPI.createAPI(formData, header).then(response => {
                commit('setcategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateCategory({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return categoryAPI.updateAPI(formData, header).then(response => {
                commit('updatecategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteCategory({commit}, id) {
        return new Promise((resolve, reject) => {
        return categoryAPI.deleteAPI(id)
        .then(response => {
            commit('deletecategory', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editCategory({commit}, id) {
            return new Promise((resolve, reject) => {
            return categoryAPI.editAPI(id)
            .then(response => {
                commit('updatecategory', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setcategory(state, category){
        state.category=category;
    },
    updatecategory(state, category){
        state.category=category;
    },
    deletecategory(state, category){
        state.category=category;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
