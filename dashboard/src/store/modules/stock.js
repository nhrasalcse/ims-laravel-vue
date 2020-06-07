import StockAPI from '../../api/stock';
const state={
    stock:[],
    activeStock: {
        id:null,
        product_id:null,
        product_qr_code :null,
        suplier :null,
        product_regular_price :null,
        sell_price :null,
        retail_price :null,
        stock_level :null,
        quentity :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeStock(state) {
        return state.activeStock;
    }
};
const actions= {
    getStock({commit},page) {
        return new Promise((resolve, reject) => {
            StockAPI.getAPI(page).then(response => {
                commit('setStock', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createStock({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return StockAPI.createAPI(formData, header).then(response => {
                commit('setStock', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updateStock({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return StockAPI.updateAPI(formData, header).then(response => {
                commit('updateStock', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    searchStock({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return StockAPI.searchAPI(formData, header).then(response => {
                commit('updateStock', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteStock({commit}, id) {
        return new Promise((resolve, reject) => {
        return StockAPI.deleteAPI(id)
        .then(response => {
            commit('deleteStock', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editStock({commit}, id) {
            return new Promise((resolve, reject) => {
            return StockAPI.editAPI(id)
            .then(response => {
                commit('updateStock', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setStock(state, stock){
        state.stock=stock;
    },
    updateStock(state, stock){
        state.stock=stock;
    },
    deleteStock(state, stock){
        state.stock=stock;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
