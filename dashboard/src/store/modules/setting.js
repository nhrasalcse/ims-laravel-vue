import settingAPI from '../../api/setting';
const state={
    setting:[],
    activesetting: {
        id:null,
        name:null,
        business :null,
        phone :null,
        email :null,
        address :null,
        company_details :null,
        logo :null,
        currency :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activesetting(state) {
        return state.activesetting;
    }
};
const actions= {
    getSetting({commit}) {
        return new Promise((resolve, reject) => {
            settingAPI.getAPI().then(response => {
                commit('setsetting', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createSetting({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return settingAPI.createAPI(formData, header).then(response => {
                commit('setsetting', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updataSetting({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return settingAPI.updateAPI(formData, header).then(response => {
                commit('updatesetting', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteSetting({commit}, id) {
        return new Promise((resolve, reject) => {
        return settingAPI.deleteAPI(id)
        .then(response => {
            commit('deletesetting', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editSetting({commit}, id) {
            return new Promise((resolve, reject) => {
            return settingAPI.editAPI(id)
            .then(response => {
                commit('updatesetting', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setsetting(state, setting){
        state.setting=setting;
    },
    updatesetting(state, setting){
        state.setting=setting;
    },
    deletesetting(state, setting){
        state.setting=setting;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
