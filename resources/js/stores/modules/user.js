import Vue from 'vue'
import router from "../../router/Router"
window.axios = require('axios')

import Token from "./auth-token"
export default {
    state: {
        isLoggedIn: false,
        token: '',
        userName:'',
        user_type:''
    },
    getters: {
        TOKEN: state => {
            return state.token
        },
        USER_NAME: state => {
            return state.userName
        },
        USER_TYPE: state => {
            return state.user_type
        },
        IS_LOGGED_IN: state=>{
            return state.isLoggedIn
        }
    },
    mutations: {
        SET_TOKEN: (state , payload) => {
            state.token = payload
        },
        SET_USER_NAME: (state , payload) => {
            state.userName = payload
        },
        SET_USER_TYPE: (state , payload) => {
            state.user_type = payload
        },
        SET_IS_LOGGED_IN:(state, payload)=>{
            state.isLoggedIn = payload;
        },
    },
    actions: {
        LOGIN: ({dispatch,commit}, payload) => {
            return new Promise((resolve, reject) => {
                let msg;
                axios
                    .post('/auth/login', payload)
                    .then(({data, status}) => {
                        if (status === 200) {
                            const access_token = data.access_token
                            const user_name = data.user_name
                            const user_type = data.user_type

                            if (Token.isValid(access_token)) {
                                commit("SET_TOKEN", access_token);
                                commit("SET_USER_NAME", user_name);
                                commit("SET_USER_TYPE", user_type);
                                commit("SET_IS_LOGGED_IN", true);
                                if(user_type === 1){
                                    router.push('/admin-dashboard')
                                }else if(user_type === 2){
                                    router.push('/author-dashboard')
                                }else if(user_type === 3){
                                    router.push('/home')
                                }
                                resolve(true);
                            }
                            return Promise.reject(msg = 'Bad Request!');
                        }
                    })
                    .catch(error => {
                        if(msg){
                            reject(error)
                        }else{
                            reject(error.response.data.err)
                        }
                    });
            });
        },
        REGISTER: ({dispatch,commit}, payload) => {
            return new Promise((resolve, reject) => {
                let msg;
                axios
                    .post('/auth/register', payload)
                    .then(({data, status}) => {
                        if (status === 200) {
                            resolve(true);
                        }
                    })
                    .catch(error => {
                        if(msg){
                            reject(error)
                        }else{
                            reject(error.response)
                        }
                    });
            });
        },
        LOGOUT: ({commit}) => {
            commit("SET_TOKEN", '');
            commit("SET_USER_NAME", '');
            commit("SET_USER_TYPE", '');
            commit("SET_IS_LOGGED_IN", false);
            window.localStorage.clear();
            window.sessionStorage.clear();
            return true;
        },

    }
}
