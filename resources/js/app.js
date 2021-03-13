import Vue from 'vue'
import Vuetify from 'vuetify'
import axios from 'axios'
import store from './stores/store'
window.axios = axios

let api_url = process.env.MIX_API_URL;

axios.defaults.baseURL = api_url+'/api/v1/'
const cons_url = api_url+'/api/v1/'
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

axios.interceptors.response.use(undefined, error => {
    console.log(error.response.data)
    if (error.response.status === 422) {
        Object.keys(error.response.data.msg).forEach(function(k){
            store.dispatch('SNACKBAR', {msg : error.response.data.msg[k],type:'red',showing:true})
        });
    }else{
        store.dispatch('SNACKBAR', {msg : error.response.data.msg,type:'red',showing:true})
    }
    return Promise.reject(error);
});



Vue.use(Vuetify, axios)
const vuetify = new Vuetify()
const opts = {}
const vi = new Vuetify(opts)
export default {vi,cons_url}

Vue.component('AppHome', require('./views/AppHome.vue').default)

import router from './router/Router.js'
import {mapActions} from "vuex";

const app = new Vue({
    el: '#app',
    vuetify,
    store,
    router,
})



