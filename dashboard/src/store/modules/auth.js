import auth from '../../api/auth_api';
// const axios = require('axios');

const state={
    token:null,
    user:null,
    authenticated:null
};
const getters ={
        authenticated(state){
            return state.token;
        },
        user(state){
            return state.user;

        },
};
const actions= {
    async LoginAuth({dispatch},formData,header){
        let response=await auth.Login(formData,header)
        dispatch('attempt',response.data.access_token)

    },
    async attempt({commit,state },token){
        // console.log(token)
        if(token){

            commit( 'SET_TOKEN', token)
        }if(!state.token){
            return 
        }
        try{
            let response=await auth.Me()
            commit('SET_USER',response.data);
 
        }catch(e){
            commit( 'SET_TOKEN', null)
            commit('SET_USER',null)

        }
    },
    signOut({commit},headers){
        return auth.Log_out(headers).then(response=>{
            commit( 'SET_TOKEN', null)
            commit('SET_USER',null)
        })
       
    }
};
const mutations={
    SET_TOKEN(state,token){
        state.token=token;
    },
    SET_USER(state,data){
        state.user=data;
    },
};
export default {
    namespace:true,
    state,
    getters,
    actions,
    mutations,
}
