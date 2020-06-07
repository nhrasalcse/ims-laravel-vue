import profile from '../../api/profile';
const state={
    profiles:[],
    activeProfiles: {
        id:null,
        name:null,
        phone :null,
        email :null,
        address :null,
        image :null,
    },
};
const getters ={
    activeProfiles(state){
        return state.activeProfiles;
    }
};
const actions= {
    get_data({commit}) {
        return new Promise((resolve, reject) => {
            profile.getData().then(response => {
                commit('setProfiles', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    update_data({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return profile.updateData(formData, header).then(response => {
                commit('updateProfiles', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    update_password({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return profile.updatePassword(formData, header).then(response => {
                commit('updateProfiles', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setProfiles(state, profiles){
        state.profiles=profiles;
    },
    updateProfiles(state, profiles){
        state.profiles=profiles;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
