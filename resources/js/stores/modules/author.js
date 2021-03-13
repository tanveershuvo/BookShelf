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
                axios
                    .post('/authors',{data})
                    .then(({data, status}) => {
                        if (status === 200) {
                            dispatch('ALL_AUTHORS')
                            dispatch('SNACKBAR',data)
                            resolve(true)
                        }
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        UPDATE_AUTHOR: ({dispatch,commit}, data) => {
            return new Promise((resolve, reject) => {
                axios
                    .put('/authors/'+data.id,{data})
                    .then(({data, status}) => {
                        if (status === 200) {
                            dispatch('ALL_AUTHORS')
                            dispatch('SNACKBAR',data)
                            resolve(true)
                        }
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        DELETE_AUTHOR: ({dispatch,commit}, id) => {
            return new Promise((resolve, reject) => {
                axios
                    .delete('/authors/'+ id)
                    .then(({data, status}) => {
                        if (status === 200) {
                            dispatch('ALL_AUTHORS')
                            dispatch('SNACKBAR',data)
                            resolve(true)
                        }
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },

    }
}
