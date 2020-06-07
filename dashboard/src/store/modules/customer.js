import customerAPI from '../../api/customer';
const state={
    customer:[],
    activeCustomer: {
        id:null,
        name:null,
        phone :null,
        email :null,
        gender :null,
        address :null,
        details :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeCustomer(state) {
        return state.activeCustomer;
    }
};
const actions= {
    getCustomer({commit},page) {
        return new Promise((resolve, reject) => {
            customerAPI.getAPI(page).then(response => {
                commit('setCustomer', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createCustomer({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return customerAPI.createAPI(formData, header).then(response => {
                commit('setCustomer', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateCustomer({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return customerAPI.updateAPI(formData, header).then(response => {
                commit('updateCustomer', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    searchCustomer({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return customerAPI.searchAPI(formData, header).then(response => {
                commit('updateCustomer', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteCustomer({commit}, id) {
        return new Promise((resolve, reject) => {
        return customerAPI.deleteAPI(id)
        .then(response => {
            commit('deleteCustomer', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editCustomer({commit}, id) {
            return new Promise((resolve, reject) => {
            return customerAPI.editAPI(id)
            .then(response => {
                commit('updateCustomer', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setCustomer(state, customer){
        state.customer=customer;
    },
    updateCustomer(state, customer){
        state.customer=customer;
    },
    deleteCustomer(state, customer){
        state.customer=customer;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
