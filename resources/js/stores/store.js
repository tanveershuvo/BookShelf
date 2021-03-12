import Vue from "vue";
import Vuex from "vuex";

import User from "./modules/user"
import Snackbar from "./modules/snackbar"
import Loader from "./modules/loader"
import Author from "./modules/author"
import createPersistedState from "vuex-persistedstate"
Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        User,
        Snackbar,
        Loader,
        Author
    },
    plugins: [createPersistedState()],
});

export default store
