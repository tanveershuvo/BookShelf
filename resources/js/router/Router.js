import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Login from '../views/Auth/Login'
import Registration from '../views/Auth/Registration'
import Home from '../views/Home'
import AdminDashboard from '../views/Admin/AdminDashboard'
import axios from "axios"
import store from '../stores/store'


const routes = [
    { path: '/', component: Login , name:'Login'},
    { path: '/registration', component: Registration , name:'Registration'},
    { path: '/home', component: Home , name:'Home'},
    {
        path: '/admin-dashboard',
        component: AdminDashboard ,
        name:'AdminDashboard',
        beforeEnter: (to, from, next) => {
            if(store.getters.USER_TYPE === 1) {
                next();
            } else {
                next('/');
            }
        }
        },
    { path: '/*', component: Home , name:''},
]
const router = new VueRouter({
    routes,
    hashbang:false,
    mode:'history'
});
router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/','/registration'];
    const authRequired = !publicPages.includes(to.path);
    const authNotRequired = publicPages.includes(to.path);
    const loggedIn = store.getters.IS_LOGGED_IN
    const token = store.getters.TOKEN
    const usertype = store.getters.USER_TYPE

    if (authRequired && !loggedIn) {
        return next('/')
    }

    if(authNotRequired && loggedIn && usertype === 1){
        return next('/admin-dashboard')
    }else if(authNotRequired && loggedIn && usertype === 2){
        return next('/author-dashboard')
    }else if(authNotRequired && loggedIn && usertype === 3){
        return next('/home')
    }
    axios.defaults.headers.common = {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer'+ token,
    }
    next();
})

export default router
