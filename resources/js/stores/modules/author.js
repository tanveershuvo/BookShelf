window.axios = require('axios')
import Token from "./auth-token"
export default {
    state: {
        authors:[]
    },
    getters: {
        GET_ALL_AUTHORS: state => {
            return state.authors
        }
    },
    mutations: {
        SET_ALL_AUTHORS: (state , payload) => {
            state.authors = payload
        }
    },
    actions: {
        ALL_AUTHORS: ({dispatch,commit}, payload) => {
            return new Promise((resolve, reject) => {
                let msg;
                axios
                    .get('/authors')
                    .then(({data, status}) => {
                        if (status === 200) {
                            commit("SET_ALL_AUTHORS", data);
                            resolve(true)
                        }
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        ADD_AUTHOR: ({dispatch,commit}, data) => {
            return new Promise((resolve, reject) => {
                let msg;
                axios
                    .post('/authors',{data})
                    .then(({data, status}) => {
                        if (status === 200) {
                            console.log(data)
                            dispatch('ALL_AUTHORS')
                            dispatch('SNACKBAR',data)
                            resolve(true)
                        }
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        }

    }
}
