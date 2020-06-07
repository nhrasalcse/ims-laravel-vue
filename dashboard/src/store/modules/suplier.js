import suplierAPI from '../../api/suplier';
const state={
    suplier:[],
    activesuplier: {
        id:null,
        name:null,
        phone :null,
        email :null,
        address :null,
        description :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activesuplier(state) {
        return state.activesuplier;
    }
};
const actions= {
    getSuplier({commit},page) {
        return new Promise((resolve, reject) => {
            suplierAPI.getAPI(page).then(response => {
                commit('setsuplier', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createSuplier({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return suplierAPI.createAPI(formData, header).then(response => {
                commit('setsuplier', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateSuplier({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return suplierAPI.updateAPI(formData, header).then(response => {
                commit('updatesuplier', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteSuplier({commit}, id) {
        return new Promise((resolve, reject) => {
        return suplierAPI.deleteAPI(id)
        .then(response => {
            commit('deletesuplier', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editSuplier({commit}, id) {
            return new Promise((resolve, reject) => {
            return suplierAPI.editAPI(id)
            .then(response => {
                commit('updatesuplier', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setsuplier(state, suplier){
        state.suplier=suplier;
    },
    updatesuplier(state, suplier){
        state.suplier=suplier;
    },
    deletesuplier(state, suplier){
        state.suplier=suplier;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
