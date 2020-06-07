import userAPI from '../../api/user';
const state={
    user:[],
    activeUser: {
        id:null,
        name:null,
        phone :null,
        email :null,
        address :null,
        status :null,
        image :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeUser(state) {
        return state.activeUser;
    }
};
const actions= {
    getUser({commit},page) {
        return new Promise((resolve, reject) => {
            userAPI.getAPI(page).then(response => {
                commit('setUser', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getRole({commit}) {
        return new Promise((resolve, reject) => {
            userAPI.getRoleAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createUser({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return userAPI.createAPI(formData, header).then(response => {
                commit('createUser', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateUser({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return userAPI.updateAPI(formData, header).then(response => {
                commit('updateUser', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteUser({commit}, id) {
        return new Promise((resolve, reject) => {
        return userAPI.deleteAPI(id)
        .then(response => {
            commit('deleteUser', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editUser({commit}, id) {
            return new Promise((resolve, reject) => {
            return userAPI.editAPI(id)
            .then(response => {
                commit('updateUser', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setUser(state, user){
        state.user=user;
    },
    createUser(state, user){
        state.user=user;
    },
    updateUser(state, user){
        state.user=user;
    },
    deleteUser(state, user){
        state.user=user;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
