import invoiceAPI from '../../api/invoice';
const state={
    invoice:[],
    activeinvoice: {
        id:null,
        customer_id:null,
        total :null,
        discount :null,
        paid :null,
        due :null,
        date :null,
        payment_method :null,
        delete_status :null,
        user_id :null,
    },

};
const getters ={
    activeinvoice(state) {
        return state.activeinvoice;
    }
};
const actions= {
    getInvoice({commit},page) {
        return new Promise((resolve, reject) => {
            invoiceAPI.getAPI(page).then(response => {
                commit('setinvoice', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getCustomerInvoice({commit}) {
        return new Promise((resolve, reject) => {
            invoiceAPI.getCustomerAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    getStockInvoice({commit}) {
        return new Promise((resolve, reject) => {
            invoiceAPI.getStockAPI().then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    findProduct({commit},id) {
        return new Promise((resolve, reject) => {
            invoiceAPI.findProductAPI(id).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    createInvoice({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return invoiceAPI.createAPI(formData, header).then(response => {
                commit('setinvoice', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    updataInvoice({commit}, formData, header) {
        return new Promise((resolve, reject) => {
            return invoiceAPI.updateAPI(formData, header).then(response => {
                commit('updateinvoice', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
    deleteInvoice({commit}, id) {
        return new Promise((resolve, reject) => {
        return invoiceAPI.deleteAPI(id)
        .then(response => {
            commit('deleteinvoice', response.data.data);
            resolve(response);
        }).catch(error => {
            reject(error);
        })
    });
},
    editInvoice({commit}, id) {
            return new Promise((resolve, reject) => {
            return invoiceAPI.editAPI(id)
            .then(response => {
                commit('updateinvoice', response.data.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            })
        });
    },
};
const mutations={
    setinvoice(state, invoice){
        state.invoice=invoice;
    },
    updateinvoice(state, invoice){
        state.invoice=invoice;
    },
    deleteinvoice(state, invoice){
        state.invoice=invoice;
    }
};
export default {
    state,
    getters,
    actions,
    mutations,
}
